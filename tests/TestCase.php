<?php

namespace JosanBr\GalaxPay\Tests;

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
        $app['config']->set('galax_pay', require __DIR__ . '/../config/galax_pay.php');

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function usesFileSessionAsClient($app)
    {
        $app->config->set('galax_pay.auth_as_partner', false);
        $app->config->set('galax_pay.session_driver', 'file');
    }

    protected function usesFileSessionAsPartner($app)
    {
        $app->config->set('galax_pay.auth_as_partner', true);
        $app->config->set('galax_pay.session_driver', 'file');
    }

    protected function usesDatabaseSession($app)
    {
        $app->config->set('galax_pay.auth_as_partner', true);
        $app->config->set('galax_pay.session_driver', 'database');
    }
}
    