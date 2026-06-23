<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionInvoiceCreatedMail;
use App\Models\InvoiceModel;
use App\Models\SubscriptionModel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscriptions';

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
        $users = User::with(['role'])->get();
        $now   = now();
        $default_subscription = SubscriptionModel::where('default',true)->first();
        
        $users->filter( fn($user) => $user->role->name == 'client' && !empty($user->subscription) && $user->activeSubscription->default == false )->each(
            function($user) use($now, $default_subscription) {
                $days_to_expiry = floor($now->diffInDays($user->subscription->end_date));  
                print_r($days_to_expiry);            
                $invoice        = array();
                
                if( $days_to_expiry < 0 && $user->activeSubscription->default == false){
                    $user->subscription()->update([
                        'billing_cycle'   => 'infinity',
                        'start_date'      => null,
                        'end_date'        => null,
                        'subscription_id' => $default_subscription->id
                    ]);                            
                }             

                switch($user->subscription->billing_cycle){
                    case "monthly":                       
                        if( $days_to_expiry == 7 ){
                            $invoice = [
                                'amount'          => $user->activeSubscription->price,
                                'due_date'        => $user->subscription->end_date,
                                'invoice_number'  => now()->format('Ymdhis'),
                                'sourceable_id'   => $user->activeSubscription->id,
                                'sourceable_type' => $user->activeSubscription::class,
                                'targetable_id'   => $user->subscription->id,
                                'targetable_type' => $user->subscription::class,
                                'user_id'         => $user->id
                            ]; 
                        }
                    break;
                    case "yearly":
                        if( $days_to_expiry == 28 ){
                            $invoice = [
                                'amount'          => $user->activeSubscription->price * 12,
                                'due_date'        => $user->subscription->end_date,
                                'invoice_number'  => now()->format('Ymdhis'),
                                'sourceable_id'   => $user->activeSubscription->id,
                                'sourceable_type' => $user->activeSubscription::class,
                                'targetable_id'   => $user->subscription->id,
                                'targetable_type' => $user->subscription::class,
                                'user_id'         => $user->id
                            ]; 
                        }                        
                    break;
                }

                if( !empty($invoice) ){
                    Mail::to($user)->send(
                        new SubscriptionInvoiceCreatedMail(
                            InvoiceModel::create($invoice)
                        )
                    );                    
                }
            }
        );
    }
}
