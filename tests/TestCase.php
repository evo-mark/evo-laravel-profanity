<?php

namespace EvoMark\EvoLaravelProfanity\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use EvoMark\EvoLaravelProfanity\ServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
