<?php

use Webudvikleren\UtmManager\Facades\Utm;
use Webudvikleren\UtmManager\UtmManager;

it('resolves to UtmManager instance', function () {
    expect(Utm::getFacadeRoot())->toBeInstanceOf(UtmManager::class);
});

it('hasAny returns false when no UTM data in session', function () {
    expect(Utm::hasAny())->toBeFalse();
});

it('hasAny returns true when at least one UTM value exists', function () {
    session(['utm_source' => 'google']);

    expect(Utm::hasAny())->toBeTrue();
});

it('hasAny returns false when all values are null', function () {
    session([
        'utm_source' => null,
        'utm_medium' => null,
    ]);

    expect(Utm::hasAny())->toBeFalse();
});

it('hasAny returns false when all values are empty strings', function () {
    session([
        'utm_source' => '',
        'utm_medium' => '',
    ]);

    expect(Utm::hasAny())->toBeFalse();
});
