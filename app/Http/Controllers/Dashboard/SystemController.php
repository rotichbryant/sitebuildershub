<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SystemRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method displays a list of system settings such as mail and company logo/icon.
     */
    public function index()
    {
        // Get the first row of the company table
        $company = Company::first();

        // Get the mail settings from the config file
        $mail = [
            'host'     => config('mail.mailers.smtp.host'),
            'port'     => config('mail.mailers.smtp.port'),
            'username' => config('mail.mailers.smtp.username'),
            'password' => config('mail.mailers.smtp.password'),
        ];

        // Get the logo and icon images
        $images = [
            'logo' => $company->logo,
            'icon' => $company->icon
        ];

        // Render the view and pass the data
        return Inertia::render('Dashboard/System', [
            'mail' => $mail,
            'images' => $images,
            // Pass the status of the session, if it exists
            'status' => session('status')
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
    public function store(SystemRequest $request)
    {
        //
        $form_data = $request->validated();
                
        if( $form_data['tab'] == 'images' ){

            $company   = Company::first();

            if( isset($form_data['icon']) ){

                $image = $request->file('icon');
                $name  = time().'.'.$image->getClientOriginalExtension();
                $image->move(storage_path('app/images'), $name);

                Company::where('id', $company->id)->update([ 'icon' => $name ]);
            }

            if( isset($form_data['logo']) ){

                $image = $request->file('logo');
                $name  = time().'.'.$image->getClientOriginalExtension();
                $image->move(storage_path('app/images'), $name);

                Company::where('id', $company->id)->update([ 'logo' => $name ]);
            }


            return response()->json(array('status' => 'success', 'message' => 'Images updated successfully.'));
        }
        
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
