<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'engagespark' => [
        'api_key' => env('ENGAGESPARK_API_KEY'),
        'org_id' => env('ENGAGESPARK_ORGANIZATION_ID'),
        'sender_id' => env('ENGAGESPARK_SENDER_ID', 'serbis.io'),
        'end_points' => [
            'sms' => env('ENGAGESPARK_SMS_ENDPOINT', 'https://start.engagespark.com/api/v1/messages/sms'),
            'topup' => env('ENGAGESPARK_AIRTIME_ENDPOINT', 'https://api.engagespark.com/v1/airtime-topup'),
        ],
        'web_hooks' => [
            'sms' => env('ENGAGESPARK_SMS_WEBHOOK', env('APP_URL', 'http://localhost') . '/webhook/engagespark/sms'),
            'topup' => env('ENGAGESPARK_AIRTIME_WEBHOOK', env('APP_URL', 'http://localhost') . '/webhook/engagespark/airtime'),
        ],
    ],

];
