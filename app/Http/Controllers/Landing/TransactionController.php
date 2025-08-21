<?php

namespace App\Http\Controllers\Landing;

use App\Exceptions\PesapalException;
use App\Http\Controllers\Controller;
use App\Models\PlacementModel;
use App\Models\PostingModel;
use App\Models\PromotionModel;
use App\Models\TransactionModel;
use App\Services\PesaPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class TransactionController extends Controller
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
    public function create(PromotionModel $promotion, PesaPalService $pesapal)
    {
        try {
            $user = auth()->user();

            $ipn_data             = array(
                'ipn_notification_type' => 'GET',
                'url'                   => route('landing.transactions.promotion.complete',['promotion' => $promotion->id])
            );

            $auth                 = $pesapal->authenticate();
            $ipn                  = $pesapal->registerIPN($ipn_data,$auth->token);

            $desc_search          = ['first_name','last_name','title','amount'];
            $desc_replace         = [$user->first_name, $user->last_name, $promotion->posting->title, $promotion->amount];
           
            $order_data           = [
                'id'              => $promotion->id,
                'currency'        => 'KES',
                'amount'          => $promotion->amount,
                'description'     => str_replace($desc_search,$desc_replace,config('services.pesapal.messages.promotion')),
                'callback_url'    => route('landing.transactions.promotion.complete',['promotion' => $promotion->id]),
                'notification_id' => $ipn['ipn_id'],
                'billing_address' => [
                    'first_name'   => $user->first_name,
                    'last_name'    => $user->last_name,
                    'phone_number' => $user->phone_number,
                    'email'        => $user->email
                ]
            ];

            $order = $pesapal->order($order_data,$auth->token);

            $transaction = new TransactionModel([
                'amount'            => $promotion->amount,
                'tracking_id'       => $order['order_tracking_id'],
            ]);

            $transaction->sourceable()->associate($promotion->placement);
            $transaction->targetable()->associate($promotion);
            $transaction->user()->associate($user);
            $transaction->save();

            return back()->with('data',compact('order'));

        } catch(PesapalException $error){

        }
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, PromotionModel $promotion, PesaPalService $pesapal)
    {
        //
        if( $promotion->transaction->status == 200 ){
            return redirect()->route('landing.mypostings');
        }

        $query                  = $request->query();
        $auth                   = $pesapal->authenticate();
        $order                  = $pesapal->transactionStatus($query['OrderTrackingId'],$auth->token);     
        $user                   = $promotion->posting->user;
        $update_data            = Arr::only($order,['status','status_code','reference','confirmation_code','payment_method']);    
        $update_data['paid_at'] = $order['created_date'];

        $promotion->transaction()->update($update_data);   
        $transaction = $promotion->transaction;

        return Inertia::render('Landing/PaymentSuccess',compact('transaction','user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
