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
    'ref'          => \JosanBr\GalaxPay\Models\GalaxPayClient::class,
    // Columns
    'model_type'   => 'model_type',
    'model_id'     => 'model_id',
    'galax_id'     => 'galax_id',
    'galax_hash'   => 'galax_hash',
    'webhook_hash' => 'webhook_hash',
],

'galax_pay_sessions' => [
    'ref'          => \JosanBr\GalaxPay\Models\GalaxPaySession::class,
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

If you use `auth_as_partner = true` partner authentication, you must pass the client's galax_id as an argument:

```php
$data = GalaxPay::listCustomers([], ['client_galax_id' => $clientGalaxId]);
```

You can see the available endpoints [here](https://github.com/josan-br/laravel-galax-pay/blob/master/config/endpoints.php).

All endpoints receive a single array type function parameter, in the following format:

```php
/**
 * GET example
 * 
 * @var array|\JosanBr\GalaxPay\QueryParams $queryParams
 * @var array|\JosanBr\GalaxPay\Http\Options $options
 */

$res = GalaxPay::listCustomers($queryParams, $options);

/**
 * POST example
 * 
 * @var array|\JosanBr\GalaxPay\Abstracts\Model $data
 * @var array|\JosanBr\GalaxPay\Http\Options $options
 */

$res = GalaxPay::createCustomer($data, $options);

/**
 * PUT example
 * 
 * @var int|string $id
 * @var array|\JosanBr\GalaxPay\Abstracts\Model $data
 * @var array|\JosanBr\GalaxPay\Http\Options $options
 */

$res = GalaxPay::editCustomer($id, $data, $options);

/**
 * DELETE example
 * 
 * @var int|string $id
 * @var array|\JosanBr\GalaxPay\Http\Options $options
 */

$res = GalaxPay::deleteCustomer($id, $options);
```

The QueryParams class has only the common parameters between the data fetching endpoints, to see all the parameters that each endpoint accepts, consult the [Galax Pay documentation.](https://docs.galaxpay.com.br)
