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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'github' => [
        'client_id' => env('GITHUB_ID', 'd82aded374761f0eca04'),
        'client_secret' => env('GITHUB_SECRET', '4d926e7fe424fc68c370e3e61b1bcd9b4c40bd5f'),
        'redirect' => env('GITHUB_URL', 'https://sipos.herokuapp.com/github/callback'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID', '855020589039-a705qofl7eagtoi9j7e0m9ikqherlp79.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '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'),
        'redirect'      => env('GOOGLE_URL', 'https://sipos.herokuapp.com/google/callback'),
    ],

];
