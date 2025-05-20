<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreatePlacementRequest;
use App\Http\Requests\Dashboard\UpdatePlacementRequest;
use App\Models\PlacementModel;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $placements = PlacementModel::paginate(10);

        return Inertia::render('Dashboard/Placement',[
            'status'     => session('status'),
            'placements' => $placements
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
    public function store(CreatePlacementRequest $request)
    {
        //
        $validated               = $request->validated();
        $validated['company_id'] = $request->user()->company_id;

        PlacementModel::create($validated);

        return back()->with('message', 'Placement created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlacementModel $placement)
    {
        return back()->with('data',compact('placement'));
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
    public function update(UpdatePlacementRequest $request, PlacementModel $placement)
    {
        //
        $validated = $request->validated();

        $placement->update($validated);

        return back()->with('message', 'Placement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlacementModel $placement)
    {
        //
        $placement->delete();

        return back()->with('message', 'Placement has been deleted');
    }
}
