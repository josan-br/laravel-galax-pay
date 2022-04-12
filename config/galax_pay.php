<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Galax Pay Environment
     |--------------------------------------------------------------------------
     |
     | This value defines the environment in which Galax Pay will run,
     | 'sandbox' for development and 'production' for production environment.
     | It also determines the URL that will be used as a basis for requests.
     |
     */

    'env' => env('GALAX_PAY_ENV', 'sandbox'),

    'api_urls' => [
        'production' => env('GALAX_PAY_URL_PRODUCTION', 'https://api.galaxpay.com.br/v2'),
        'sandbox' => env('GALAX_PAY_URL_SANDBOX', 'https://api.sandbox.cloud.galaxpay.com.br')
    ],

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Partner
     |--------------------------------------------------------------------------
     |
     | This value determines whether authentication in Galax Pay will be as a partner
     |
     */

    'auth_as_partner' => env('GALAX_PAY_AUTH_AS_PARTNER', true),

    'galax_id' => env('GALAX_PAY_ID', '5473'),

    'galax_hash' => env('GALAX_PAY_HASH', '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe'),

    'webhook_hash' => env('GALAX_PAY_WEBHOOK_HASH', '5541f646369927c19b2e2132f7090ff3'),

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Scopes
     |--------------------------------------------------------------------------
     |
     | All possible Galax Pay request scopes
     |
     */
    'scopes' => 'boletos.read card-brands.read cards.read cards.write carnes.read charges.read charges.write customers.read customers.write payment-methods.read plans.read plans.write subscriptions.read subscriptions.write transactions.read transactions.write webhooks.write',

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Session Driver
     |--------------------------------------------------------------------------
     |
     | This value determines whether authentication sections will be
     | saved to 'file' or 'database'. If you are going to operate as
     | a partner ('auth_as_partner' => true) change value to 'database'.
     |
     */
    'session_driver' => env('GALAX_PAY_SESSION_DRIVER', 'database'),

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Client
     |--------------------------------------------------------------------------
     |
     | Table for clients keys in Galax Pay. To create a relationship 
     | with the table, set the value of foreign.column and foreign.on.
     |
     */

    'clients_table' => [
        'name' => 'galax_pay_clients',
        'model' => \JosanBr\GalaxPay\Models\GalaxPayClient::class,
        // Columns
        'galax_id' => 'galax_id',
        'galax_hash' => 'galax_hash',
    ],

    /*
    |--------------------------------------------------------------------------
    | Galax Pay Sessions
    |--------------------------------------------------------------------------
    |
    | Table for Galax Pay sessions in the database
    |
    */

    'sessions_table' => [
        'name' => 'galax_pay_sessions',
        'model' => \JosanBr\GalaxPay\Models\GalaxPaySession::class,
        // Columns
        'scope' => 'scope',
        'expires_in' => 'expires_in',
        'token_type' => 'token_type',
        'access_token' => 'access_token',
        'client_id' => 'galax_pay_client_id',
    ]
];
