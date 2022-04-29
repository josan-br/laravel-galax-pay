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
        'sandbox'    => env('GALAX_PAY_URL_SANDBOX', 'https://api.sandbox.cloud.galaxpay.com.br')
    ],

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Partner
     |--------------------------------------------------------------------------
     |
     | This value defines the Galax Pay API authentication as a partner.
     | 
     | If you are only going to work with one client, change the 'session_driver'
     | to 'file' and put your credentials in credentials.partner and the client's
     | in credentials.client.
     |
     | If you are going to work with more than one client, change the 'session_driver'
     | to 'database' and publish the migrations.
     |
     */

    'auth_as_partner' => env('GALAX_PAY_AUTH_AS_PARTNER', false),

    /*
     |-------------------------------------------------------------------------- 
     | Galax Pay Credentials
     |--------------------------------------------------------------------------
     |
     | After creating a Galax Pay account, you are given a 
     | 'galax_id' and a 'galax_hash' to authenticate to the API.
     | 
     | If you are authenticating as a partner, put your credentials in 
     | 'credentials.partner' and if you are only working with one client, 
     | put the client's credentials in 'credentials.client'. Otherwise, 
     | put your credentials in 'credentials.client'.
     |
     */

    'credentials' => [
        'client' => [
            'id' => env('GALAX_PAY_CLIENT_ID', null),
            'hash' => env('GALAX_PAY_CLIENT_HASH', null),
        ],
        'partner' => [
            'id' => env('GALAX_PAY_PARTNER_ID', null),
            'hash' => env('GALAX_PAY_PARTNER_HASH', null),
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Webhook Hash
     |--------------------------------------------------------------------------
     |
     | The webhook_hash is for you to be sure that it was Galax Pay that 
     | sent you the request and not a third party trying to break into 
     | your system, it can be obtained from the Galax Pay system.
     |
     */

    'webhook_hash' => env('GALAX_PAY_WEBHOOK_HASH', null),

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
     | This value determines whether authentication sections will be saved in 
     | 'file' or 'database'. Session driver: database, must be used when 
     | authentication is with partner and you are working with more than 
     | one customer, customer credentials must be saved in galax_pay_clients table.
     |
     */

    'session_driver' => env('GALAX_PAY_SESSION_DRIVER', 'file'),

    /*
     |--------------------------------------------------------------------------
     | Galax Pay Client
     |--------------------------------------------------------------------------
     |
     | Table responsible for storing the credentials of Galax Pay clients.
     | The entity and entity_id columns refer to the entity
     | that owns the galax_id and galax_hash credentials.
     |
     */

    'galax_pay_clients' => [
        'model'      => \JosanBr\GalaxPay\Models\GalaxPayClient::class,
        // Columns
        'entity'     => 'entity',
        'entity_id'  => 'entity_id',
        'galax_id'   => 'galax_id',
        'galax_hash' => 'galax_hash',
    ],

    /*
    |--------------------------------------------------------------------------
    | Galax Pay Sessions
    |--------------------------------------------------------------------------
    |
    | Table responsible for storing session tokens in the Galax Pay API
    |
    */

    'galax_pay_sessions' => [
        'model'        => \JosanBr\GalaxPay\Models\GalaxPaySession::class,
        // Columns
        'scope'        => 'scope',
        'expires_in'   => 'expires_in',
        'token_type'   => 'token_type',
        'access_token' => 'access_token',
        'client_id'    => 'galax_pay_client_id',
    ]
];
