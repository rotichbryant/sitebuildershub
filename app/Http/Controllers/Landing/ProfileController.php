<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\BusinessProfileRequest;
use App\Http\Requests\Landing\CreateStoreRequest;
use App\Models\BusinessProfileModel;
use App\Models\BusinessStoreModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Landing/Profile',[
            'status' => session('status')
        ]);
    }  

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $tab)
    {
        //
        $data = [
            'tab'       => $tab,
            'status'    => session('status'),
            'locations' => config('location'),
        ];

        $user           = auth('client')->user();

        switch($tab){
            case 'personal':
                $data['user']             = $user;
            break;
            case 'business':
                $data['maps']              = config('services.google');
                $data['business_profile']  = $user->business_profile;
                $data['stores']            = !empty($data['business_profile']) ? $data['business_profile']->stores : array();
            break;
        }

        return Inertia::render('Landing/Profile',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function business(BusinessProfileRequest $request)
    {
        //
        $validated = $request->validated();

        $user = auth('client')->user();

        if( empty($user->business_profile) ){
            BusinessProfileModel::create(
                array_merge($validated, [
                    'user_id' => $user->id
                ])
            );
        }
        
        if( !empty($user->business_profile) ){
            $user->business_profile->update($validated);
        }

        return back()->with([
            'message' => 'Business Profile Updated Successfully'
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function business_store(CreateStoreRequest $request)
    {
        //
        $validated = $request->validated();

        $user = auth('client')->user();

        $validated['coords']              = json_encode($validated['coords']);
        $validated['open_from']           = json_encode($validated['open_from']);
        $validated['open_to']             = json_encode($validated['open_to']);
        $validated['working_days']        = json_encode($validated['working_days']);
        $validated['business_profile_id'] = $user->business_profile->id;
        
        BusinessStoreModel::create($validated);

        return back()->with([
            'message' => 'Business Store Created Successfully'
        ]);
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
