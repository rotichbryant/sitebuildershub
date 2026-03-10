<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\StoreSubscriptionRequest;
use App\Models\SubscriptionModel;
use App\Models\User;
use App\Models\UserSubscriptionModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subscriptions  = SubscriptionModel::where('active',true)->get();
        $session        = session('status');

        return Inertia::render('Landing/Subscriptions',compact('subscriptions','session'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SubscriptionModel $subscription)
    {
        //
        $session        = session('status');
    
        return Inertia::render('Landing/SubscriptionCheckout',compact('subscription','session'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $validated = $request->validated();
        
        $user              = User::find($validated['user_id']);
        $user_subscription = array();
        
        if( !is_null($user->subscription) ){
            $user->subscription()->update([
                'subscription_id' => $validated['subscription_id'],
                'active'          => false,
                'billing_cycle'   => $validated['subscription_type'],
                'user_id'         => $validated['user_id'],
                'end_date'        => $validated['end_date'],
                'start_date'      => $validated['start_date'],                
            ]);
            $user_subscription = $user->subscription;
        }

        if( is_null($user->subscription) ){
            $user_subscription = UserSubscriptionModel::create([
                'subscription_id' => $validated['subscription_id'],
                'billing_cycle'   => $validated['subscription_type'],
                'user_id'         => $validated['user_id'],
                'end_date'        => $validated['end_date'],
                'start_date'      => $validated['start_date'],
            ]); 
        }

        return back()->with('data',compact('user_subscription'));
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
