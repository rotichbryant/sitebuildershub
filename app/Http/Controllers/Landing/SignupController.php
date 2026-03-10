<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Landing\SignupRequest;
use App\Mail\WelcomeMail;
use App\Models\Company;
use App\Models\CompanyModel;
use App\Models\SubscriptionModel;
use App\Models\User;
use App\Models\UserModel;
use App\Models\UserSubscriptionModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SignupController extends Controller
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
     *
     * This method processes a verification token, finds the associated user,
     * updates their email verification timestamp, and redirects to the landing page.
     *
     * @param Request $request The incoming HTTP request.
     * @param string $token The verification token for the user.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create(Request $request, string $token)
    {
        // Attempt to find the user with the provided token
        try {

            // Find user
            $user = User::where('token', $token)->firstOrFail();

            // Update the user's email_verified_at timestamp
            $user->update([
                'email_verified_at' => now()->format('Y-m-d H:i:s'),
                'token'             => Str::random(20),
            ]);

            // Redirect to the landing home page on successful verification
            return back()->with([
                'message' => 'Your account has been verified successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            
            // Abort with a 404 error if the user is not found
            return abort(404);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SignupRequest $request)
    {
        //
        try {
            $formData = $request->validated();

            $company      = Company::firstOrFail();
            $role         = $company->roles()->where('state',0)->firstOrFail();
            $subscription = SubscriptionModel::where('default',true)->firstOrFail();

            $user     = User::create([
                'company_id' => $company->id,
                'first_name' => $formData['first_name'],
                'last_name'  => $formData['last_name'],
                'email'      => $formData['email'],
                'role_id'    => $role->id,
                'password'   => Hash::make($formData['password']),
                'token'      => Str::random(20),
            ]);
            
            UserSubscriptionModel::create([
                'active'          => true,
                'subscription_id' => $subscription->id,
                'user_id'         => $user->id,
            ]);        

            Mail::to($user)->send(new WelcomeMail($user));

            return back()->with([
                'message' => 'Your account has been created successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            
            // Abort with a 404 error if the user is not found
            return abort(404);
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
