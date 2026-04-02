<?php

namespace App\Console\Commands;

use App\Mail\Landing\SubscriptionExpiryNotification;
use App\Models\InvoiceModel;
use App\Models\SubscriptionModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $invoices = InvoiceModel::with(['sourceable'])->where('status','unpaid')->get();
        $now      = now();
        $default_subscription = SubscriptionModel::where('default',true)->first();

        $invoices->filter( fn($invoice): bool => $invoice->source_type == 'subscription' && $invoice->sourceable->default == false )->each(
            function($invoice,$index) use($now, $default_subscription) {
                $days_to_expiry = floor($now->diffInDays($invoice->targetable->end_date));              
                $data           = [];
                switch($invoice->targetable->billing_cycle){
                    case "monthly":      
                        if( $days_to_expiry == 7){
                            $data = [
                                'markdown'   => 'emails.subscriptions.count_down_reminder',
                                'subject'    => "Action Required: $days_to_expiry days until your {$invoice->sourceable->name} subscription expires"
                            ];          
                        } 

                        
                        if( $days_to_expiry == 3){

                            $data = [
                                'markdown' => 'emails.subscriptions.count_down_reminder',
                                'subject'    => "Action Required: $days_to_expiry days until your {$invoice->sourceable->name} subscription expires"
                            ];                          

                        }                         

                        if( $days_to_expiry == 0 ){

                            $data = [
                                'markdown' => 'emails.subscriptions.final_reminder',
                                'subject'  => "Final Notice: Your {$invoice->sourceable->name} subscription will expire today"
                            ];                        

                        } 
                        
                        if( $days_to_expiry == -1){
                            $invoice->targetable()->update([
                                'billing_cycle'   => 'infinity',
                                'start_date'      => null,
                                'end_date'        => null,
                                'subscription_id' => $default_subscription->id
                            ]);
                        }                         
                    break;
                    case "yearly":
                        if( $days_to_expiry == 14){
                            
                            $data = [
                                'markdown' => 'emails.subscriptions.count_down_reminder',
                                'subject'    => "Action Required: $days_to_expiry days until your {$invoice->sourceable->name} subscription expires"
                            ];                              

                        }
                        
                        if( $days_to_expiry == 7){

                            $data = [
                                'markdown' => 'emails.subscriptions.count_down_reminder',
                                'subject'    => "Action Required: $days_to_expiry days until your {$invoice->sourceable->name} subscription expires"
                            ];                          

                        }       
                        
                        if( $days_to_expiry == 3){

                            $data = [
                                'markdown' => 'emails.subscriptions.count_down_reminder',
                                'subject'    => "Action Required: $days_to_expiry days until your {$invoice->sourceable->name} subscription expires"
                            ];                          

                        } 

                        if( $days_to_expiry == 0){
                            
                            $data = [
                                'markdown' => 'emails.subscriptions.final_reminder',
                                'subject'  => "Final Notice: Your {$invoice->sourceable->name} subscription will expire today"
                            ];  

                        } 
                        
                        if( $days_to_expiry == -1){
                            $invoice->targetable()->update([
                                'billing_cycle'   => 'infinity',
                                'start_date'      => null,
                                'end_date'        => null,
                                'subscription_id' => $default_subscription->id
                            ]);
                        }                         
                    break;
                }

                if( !empty($data) ){
                    
                    $data['end_date']   = $invoice->targetable->end_date;
                    $data['count_down'] =  $days_to_expiry;
                    $data['link']       = route('landing.invoices.pay',[ 'invoice_number' => $invoice->invoice_number]);
                    
                    Mail::to($invoice->targetable->user)->send( 
                        new SubscriptionExpiryNotification($invoice->targetable->user,$invoice->sourceable,$data) 
                    );
                
                }
            }
        );
    }
}
