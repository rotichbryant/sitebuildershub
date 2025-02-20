<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEmailAccountRequest;
use App\Models\EmailAccount;
use App\Services\MailboxService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method will display a list of the current user's email accounts
     * when the user visits the /mail page.
     */
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Get the email accounts associated with the user
        $accounts = $user->emailAccounts()->get();

        // Get the status message from the session
        $status = session('status');

        // Render the view
        return Inertia::render('Mail', compact('accounts', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created email account in storage.
     *
     * This method validates the request, adds the authenticated user's ID to the payload,
     * creates a new EmailAccount instance, and returns the created account as a JSON response.
     *
     * @param AddEmailAccountRequest $request The incoming request containing email account details
     * @return \Illuminate\Http\JsonResponse The JSON response with the created email account
     */
    public function store(AddEmailAccountRequest $request)
    {
        // Validate the request and retrieve the validated data
        $payload = $request->validated();
        
        // Add the authenticated user's ID to the payload
        $payload['user_id'] = auth()->user()->id;

        // Create a new email account with the provided data
        $account = EmailAccount::create($payload);

        // Return the created account as a JSON response
        return response()->json(compact('account'));
    }

    /**
     * Display the specified resource.
     *
     * This method uses the MailboxService to connect to the specified email account's server,
     * retrieve the list of mailboxes, and fetch the messages from the inbox.
     *
     * @param EmailAccount $account The specified email account
     * @return \Illuminate\Http\JsonResponse The JSON response containing the mailboxes
     * @throws Exception If the connection to the email server fails
     */
    public function show(EmailAccount $account)
    {
        try {
            // Create a new MailboxService instance with the email account's details
            $mailbox = new MailboxService(
                $account->username,
                $account->password,
                $account->incoming_server,
                $account->incoming_port,
            );

            // Get the list of mailboxes for the account
            $mailboxes = $mailbox->mailboxes();

            // Get the messages from the inbox
            $messages = $mailbox->getMessages();

            // Return the list of mailboxes as a JSON response
            return response()->json(compact('mailboxes','messages'));

        } catch (Exception $error) {
            // Print the error message if the connection to the email server fails
            print($error->getMessage());
        }
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
