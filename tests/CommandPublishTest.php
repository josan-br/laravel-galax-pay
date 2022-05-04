<?php

namespace JosanBr\GalaxPay\Tests;

class CommandPublishTest extends TestCase
{
    private static $choices = ['config', 'environment variables', 'migrations'];

    /**
     * @test
     */
    public function it_can_publish_config()
    {
        if (file_exists(app()->basePath('config/galax_pay.php')))
            unlink(app()->basePath('config/galax_pay.php'));

        $this->artisan('galax-pay:publish')
            ->expectsChoice('What will be published?', 'config', static::$choices)
            ->expectsOutput('Published configuration!');
    }

    /**
     * @test
     */
    public function it_can_override_published_config()
    {
        $this->artisan('galax-pay:publish')
            ->expectsChoice('What will be published?', 'config', static::$choices)
            ->expectsConfirmation('The config has already been published, replace?', 'yes')
            ->expectsOutput('Replaced configuration!');
    }

    /**
     * @test
     */
    public function it_can_publish_environment_variables()
    {
        $this->artisan('galax-pay:publish')
            ->expectsChoice('What will be published?', 'environment variables', static::$choices)
            ->expectsOutput('Published Environment Variables!');
    }

    /**
     * @test
     */
    public function it_can_publish_migrations()
    {
        $this->artisan('galax-pay:publish')
            ->expectsChoice('What will be published?', 'migrations', static::$choices)
            ->expectsConfirmation('Want to remove and publish again?', 'yes')
            ->expectsOutput('Publishing migrations!');
    }
}
