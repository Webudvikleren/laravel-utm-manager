<?php

namespace Webudvikleren\UtmManager\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Webudvikleren\UtmManager\UtmManagerServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            UtmManagerServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Utm' => \Webudvikleren\UtmManager\Facades\Utm::class,
        ];
    }
}
