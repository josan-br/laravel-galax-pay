# Laravel Galax Pay

Make requests to the Galax Pay API

## Installation

Step 1. Add Laravel Galax Pay to your project:

```
composer require josan-br/laravel-galax-pay
```

Step 2. Register `GalaxPayServiceProvider`:

-   In Laravel:

    ```php
    'providers' => [
        // ...
        \JosanBr\GalaxPay\Providers\GalaxPayServiceProvider::class,
    ];
    ```

-   In Lumen, go to the `bootstrap/app.php` file and in the providers section add:

    ```php
    $app->register(\JosanBr\GalaxPay\Providers\GalaxPayServiceProvider::class);
    ```

Step 3. Publish files:

```php
php artisan galax-pay:publish
```

This command allows publishing the settings and migrations, before publishing the migrations publish the settings.

The command doesn't publish both at once because you might want to use other tables than the ones the package provides.

In this case, just go to `config/galax_pay.php` and define the models you want to use and the referring columns.

```php
// ...
'galax_pay_clients' => [
    'model'      => \JosanBr\GalaxPay\Models\GalaxPayClient::class,
    // Columns
    'entity'     => 'entity',
    'entity_id'  => 'entity_id',
    'galax_id'   => 'galax_id',
    'galax_hash' => 'galax_hash',
],

'galax_pay_sessions' => [
    'model'        => \JosanBr\GalaxPay\Models\GalaxPaySession::class,
    // Columns
    'scope'        => 'scope',
    'expires_in'   => 'expires_in',
    'token_type'   => 'token_type',
    'access_token' => 'access_token',
    'client_id'    => 'galax_pay_client_id',
]
```

Step 4. add environment variables:

```
php artisan galax-pay:publish
```
and choose: **environment variables**

```
What will be published?:
[0] config
[1] environment variables
[2] migrations
> environment variables
```

## Usage

Use the Galax Pay facades class

```php
use JosanBr\GalaxPay\Facades\GalaxPay;
```

If using standard authentication, `auth_as_partner = false`, just call an endpoint as static function:

```php
$data = GalaxPay::listCustomers();
```

If you use auth_as_partner=true partner authentication, you must pass the client's galax_id as an argument:

```php
$data = GalaxPay::listCustomers(['clientGalaxId' => $clientGalaxId]);
```

You can see the available endpoints [here](https://github.com/josan-br/laravel-galax-pay/blob/master/config/endpoints.php).

All endpoints receive a single array type function parameter, in the following format:

```php
$data = GalaxPay::endpointName([
    /**
     * Parameters in the uri path
     */
    'params' => ['customerId' => '', 'typeId' => ''],

    /**
     * To pass parameters in the URL use the QueryParams class,
     * which takes an array of parameters.
     *
     * NOTE: Use only on data fetch endpoints
     */
    'query' => new \JosanBr\GalaxPay\QueryParams($params),
    // or use the GalaxPay Facade
    'query' => GalaxPay::queryParams($params),

    /**
     * Data to send to galax pay, can be an array or one of
     * the models available in \JosanBr\GalaxPay\Models,
     * with the exception of GalaxPayClient and GalaxPaySession
     */
    'data' => [],
]);
```

The QueryParams class has only the common parameters between the data fetching endpoints, to see all the parameters that each endpoint accepts, consult the [Galax Pay documentation.](https://docs.galaxpay.com.br)
