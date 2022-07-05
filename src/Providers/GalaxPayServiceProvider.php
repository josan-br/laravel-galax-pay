<?php

namespace JosanBr\GalaxPay\Providers;

use Illuminate\Support\ServiceProvider;

class GalaxPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([\JosanBr\GalaxPay\Commands\Publish::class]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/galax_pay.php', 'galax_pay');

        $this->app->singleton('galaxPay', function () {
            return new \JosanBr\GalaxPay\GalaxPay();
        });

        $this->app->alias('galaxPay', \JosanBr\GalaxPay\GalaxPay::class);
    }
}
