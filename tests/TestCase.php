<?php

namespace JosanBr\GalaxPay\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

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

        $app['config']->set('database.default', env('DB_CONNECTION', 'sqlite'));
        $app['config']->set('database.connections.sqlite', [
            'prefix' => '',
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => __DIR__ . '/database/database.sqlite',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
