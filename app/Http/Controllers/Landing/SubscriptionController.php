<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionModel;
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
