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
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '880959900321-ti5o09mvuedb8iqkh25m2d0n6422iced.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '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'),
        'redirect' => env('APP_URL', 'https://hare-great-ideally.ngrok-free.app') . "/auth/google/callback",
    ],
    'facebook' => [
        'client_id' => '520747644156758',
        'client_secret' => '0a146bd984be4498767f052fdf7f49c0',
        'redirect' => env('APP_URL', 'https://hare-great-ideally.ngrok-free.app') . "/auth/facebook/callback"
    ],

];
