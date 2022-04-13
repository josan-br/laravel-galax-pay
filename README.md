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
