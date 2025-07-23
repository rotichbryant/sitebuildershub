<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'google' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
        'id'      => env('GOOGLE_MAPS_ID'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'pesapal' => [
        'base_url' => [
            'live'    => 'https://pay.pesapal.com/v3/api', // live phase endpoint
            'sandbox' => 'https://cybqa.pesapal.com/pesapalv3/api', // testing phase endpoint
        ],
        'endpoints' => [
            'auth'         => '/Auth/RequestToken', // get authorization token
            'cancel'       => '/Transactions/CancelOrder',
            'getipns'      => '/URLSetup/GetIpnList', // list all Instant Payment Notification
            'status'       => '/Transactions/GetTransactionStatus', // track the transaction status
            'registeripn'  => '/URLSetup/RegisterIPN', // register Instant Payment Notification
            'ipn'          => '/URLSetup/RegisterIPN', // create an Instant Payment Notification
            'orderRequest' => '/Transactions/SubmitOrderRequest', // create an order request for a client
        ],
        'configuration' => [
            'consumer_key'    => env('PESAPAL_CONSUMER_KEY'),
            'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
            'status'          => env('PESAPAL_STATUS'),
        ],
        'messages' => [
            'promotion' => 'Advertiser {first_name} {last_name} is paying for promotion of {title}. The total amount is {amount}.'
        ]
    ],

];
