<?php

use Webudvikleren\UtmManager\UtmManager;
use Webudvikleren\UtmManager\Http\Middleware\CaptureUtmParameters;

it('merges package config', function () {
    expect(config('utm.utm_keys'))->toBe([
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ]);

    expect(config('utm.table'))->toBe('utm_visits');
});

it('registers utm singleton', function () {
    $instance = app('utm');

    expect($instance)->toBeInstanceOf(UtmManager::class);
    expect(app('utm'))->toBe($instance); // same instance (singleton)
});

it('registers middleware alias', function () {
    $router = app('router');
    $middleware = $router->getMiddleware();

    expect($middleware)->toHaveKey('utm.capture');
    expect($middleware['utm.capture'])->toBe(CaptureUtmParameters::class);
});

it('registers console commands when running in console', function () {
    $this->artisan('list')->assertSuccessful();

    // Verify the commands exist by trying to get their info
    expect(array_key_exists('utm:make-migration', \Illuminate\Support\Facades\Artisan::all()))->toBeTrue();
    expect(array_key_exists('utm:publish-model', \Illuminate\Support\Facades\Artisan::all()))->toBeTrue();
});
