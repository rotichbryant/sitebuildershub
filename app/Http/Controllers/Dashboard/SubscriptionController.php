<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateSubscriptionRequest;
use App\Http\Requests\Dashboard\UpdateSubscriptionRequest;
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
        $subscriptions = SubscriptionModel::paginate(10);

        // Render the view and pass the data
        return Inertia::render('Dashboard/Subscription', [
            'subscriptions' => $subscriptions,
        ]);
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
    public function store(CreateSubscriptionRequest $request)
    {
        //
        $user                    = $request->user();

        $validated               = $request->validated();
        $validated['company_id'] = $user->company_id;

        $validated['features']   = json_encode($validated['features']);

        SubscriptionModel::create($validated);

        return back()->with('message', 'Subscription created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionModel $subscription)
    {
        //
        return back()->with('data',compact('subscription'));
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
    public function update(UpdateSubscriptionRequest $request,  SubscriptionModel $subscription)
    {

        $validated = $request->validated();

        $subscription->update($validated);

        return back()->with('message', 'Subscription updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionModel $subscription)
    {
        //

        print_r($subscription);
        ;
        $subscription->delete();

        return back()->with('message', "Subscription {$subscription->name} deleted.");
    }
}
