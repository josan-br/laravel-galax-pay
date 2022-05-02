<?php

namespace JosanBr\GalaxPay\Tests\AsClient;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [\JosanBr\GalaxPay\Providers\GalaxPayServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('galax_pay', require __DIR__ . '/../../config/galax_pay.php');
    }
}
