<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Mail\SubscriptionReceipt;
use App\Mail\SubscriptionRenewal;
use App\Models\InvoiceModel;
use App\Models\TransactionModel;
use App\Services\PesaPalService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceModel $invoice)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function paid(Request $request, string $invoice_number, PesaPalService $pesapal)
    {
        //
        try {

            $invoice = InvoiceModel::where([
                'invoice_number' => intval($invoice_number),
                'status'         => 'unpaid'
            ])->firstOrFail();

            $transaction            = $invoice->transactions()->pending();
            $query                  = $request->query();
            $auth                   = $pesapal->authenticate();
            $order                  = $pesapal->transactionStatus($query['OrderTrackingId'],$auth->token);     
            $update_data            = Arr::only($order,['status','status_code','reference','confirmation_code','payment_method']);    
            $update_data['paid_at'] = now()->parse($order['created_date'])->format('Y-m-d h:i');


            $transaction->update($update_data);  

            $transaction = $invoice->transactions()->find($transaction->id);
                        
            $invoice->update([
                'status' => 'paid'
            ]);

            if( $invoice->source_type == 'subscription') {

                $end_date = now()->addMonth(1)->format('Y-m-d');

                if( $invoice->targetable->billing_cycle == 'yearly'){
                    $end_date = now()->addYear(1)->format('Y-m-d');
                }

                $invoice->targetable()->update([
                    'active'     => true,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $end_date,
                ]);

                Mail::to($invoice->user)->send( new SubscriptionReceipt($invoice,$transaction) );
                Mail::to($invoice->user)->send( new SubscriptionRenewal($invoice->sourceable,$invoice->targetable) );
                
            }

            return Inertia::render('Landing/InvoicePaymentSuccess',compact('invoice','transaction'));    

        } catch(ModelNotFoundException $error) {

            return redirect(route('landing.not_found'));

        }
    }    

    /**
     * Display the specified resource.
     */
    public function pay(int $invoice_number, PesaPalService $pesapal)
    {
        //
            print_r(gettype($invoice_number));
        return;
        try {

            $invoice = InvoiceModel::where([
                'invoice_number' => $invoice_number,
                'status'         => 'unpaid'
            ])->firstOrFail();
            
            $pending_transaction = $invoice->pending_transaction;

            if( $invoice->status == 'unpaid' && !is_null($pending_transaction) && !is_null($pending_transaction->payment_url) ){
                return redirect()->away($pending_transaction->payment_url);
            }

            $ipn_data             = [
                'ipn_notification_type' => 'GET',
                'url'                   => route('landing.transactions.invoice.ipn',['invoice_number' => $invoice_number])
            ];
            
            $auth                 = $pesapal->authenticate();
            $ipn                  = $pesapal->registerIPN($ipn_data,$auth->token);
            $order_data           = [
                'id'              => Str::random(10),
                'currency'        => $invoice->user->company->currency,
                'amount'          => $invoice->amount,
                'description'     => "Payment for invoice #$invoice_number",
                'callback_url'    => route('landing.invoices.paid',['invoice_number' => $invoice_number]),
                'notification_id' => $ipn['ipn_id'],
                'billing_address' => [
                    'first_name'   => $invoice->user->first_name,
                    'last_name'    => $invoice->user->last_name,
                    'phone_number' => $invoice->user->phone_number,
                    'email'        => $invoice->user->email
                ]
            ];

            $order       = $pesapal->order($order_data,$auth->token);

            $transaction = new TransactionModel([
                'amount'            => $invoice->amount,
                'tracking_id'       => $order['order_tracking_id'],
                'payment_url'       => $order['redirect_url']
            ]);

            $transaction->invoice()->associate($invoice);
            $transaction->user()->associate($invoice->user);
            $transaction->save();

            return redirect()->away($order['redirect_url']);

        } catch(ModelNotFoundException $error) {

            return redirect(route('landing.not_found'));

        }
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
