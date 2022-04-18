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
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'laravel_galax_pay');
        $app['config']->set('database.connections.laravel_galax_pay', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('galax_pay.env', 'sandbox');
        $app['config']->set('galax_pay.auth_as_partner', false);

        $app['config']->set('galax_pay.api_urls.production', 'https://api.galaxpay.com.br/v2');
        $app['config']->set('galax_pay.api_urls.sandbox', 'https://api.sandbox.cloud.galaxpay.com.br');

        $app['config']->set('galax_pay.credentials.galax_id', '5473');
        $app['config']->set('galax_pay.credentials.galax_hash', '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe');

        $app['config']->set('galax_pay.webhook_hash', null);
        $app['config']->set('galax_pay.session_driver', 'file');
        $app['config']->set('galax_pay.scopes', 'boletos.read card-brands.read cards.read cards.write carnes.read charges.read charges.write customers.read customers.write payment-methods.read plans.read plans.write subscriptions.read subscriptions.write transactions.read transactions.write webhooks.write');

        $app['config']->set('galax_pay.galax_pay_clients.entity', 'entity');
        $app['config']->set('galax_pay.galax_pay_clients.galax_id', 'galax_id');
        $app['config']->set('galax_pay.galax_pay_clients.entity_id', 'entity_id');
        $app['config']->set('galax_pay.galax_pay_clients.galax_hash', 'galax_hash');
        $app['config']->set('galax_pay.galax_pay_clients.model', \JosanBr\GalaxPay\Models\GalaxPayClient::class);

        $app['config']->set('galax_pay.galax_pay_sessions.scope', 'scope');
        $app['config']->set('galax_pay.galax_pay_sessions.expires_in', 'expires_in');
        $app['config']->set('galax_pay.galax_pay_sessions.token_type', 'token_type');
        $app['config']->set('galax_pay.galax_pay_sessions.access_token', 'access_token');
        $app['config']->set('galax_pay.galax_pay_sessions.client_id', 'galax_pay_client_id');
        $app['config']->set('galax_pay.galax_pay_sessions.model', \JosanBr\GalaxPay\Models\GalaxPaySession::class);
    }
}
