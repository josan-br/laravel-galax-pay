<?php

namespace JosanBr\GalaxPay\Tests\AsPartner;

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

        $app['config']->set('galax_pay.auth_as_partner', true);

        $app['config']->set('galax_pay.credentials.client', [
            'id' => 5473,
            'hash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe'
        ]);

        $app['config']->set('galax_pay.credentials.partner', [
            'id' => 5473,
            'hash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe'
        ]);
    }
}
