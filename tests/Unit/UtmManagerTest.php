<?php

use Webudvikleren\UtmManager\UtmManager;

it('returns null when no session data exists', function () {
    $manager = new UtmManager();

    expect($manager->get('utm_source'))->toBeNull();
});

it('returns the value from session for a given key', function () {
    session(['utm_source' => 'google']);

    $manager = new UtmManager();

    expect($manager->get('utm_source'))->toBe('google');
});

it('returns all configured keys with null defaults', function () {
    $manager = new UtmManager();

    $result = $manager->all();

    expect($result)->toBe([
        'utm_source' => null,
        'utm_medium' => null,
        'utm_campaign' => null,
        'utm_term' => null,
        'utm_content' => null,
    ]);
});

it('returns session values for configured keys', function () {
    session([
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
        'utm_campaign' => 'spring_sale',
    ]);

    $manager = new UtmManager();

    expect($manager->all())->toBe([
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
        'utm_campaign' => 'spring_sale',
        'utm_term' => null,
        'utm_content' => null,
    ]);
});
