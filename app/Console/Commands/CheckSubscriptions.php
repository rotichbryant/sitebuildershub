<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionInvoiceCreatedMail;
use App\Models\InvoiceModel;
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
        $users = User::all();
        $now   = now();
        
        $users->filter( fn($user) => !empty($user->subscription) )->each(
            function($user) use($now) {
                $days_to_expiry = floor($now->diffInDays($user->subscription->end_date));              
                $invoice        = array();
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
