<?php

use Illuminate\Http\Request;
use Webudvikleren\UtmManager\Http\Middleware\CaptureUtmParameters;

it('stores UTM params from request query into session', function () {
    $request = Request::create('/', 'GET', [
        'utm_source' => 'google',
        'utm_medium' => 'cpc',
        'utm_campaign' => 'spring_sale',
        'utm_term' => 'shoes',
        'utm_content' => 'banner',
    ]);

    $middleware = new CaptureUtmParameters();
    $middleware->handle($request, fn ($req) => $req);

    expect(session('utm_source'))->toBe('google');
    expect(session('utm_medium'))->toBe('cpc');
    expect(session('utm_campaign'))->toBe('spring_sale');
    expect(session('utm_term'))->toBe('shoes');
    expect(session('utm_content'))->toBe('banner');
});

it('ignores non-UTM query params', function () {
    $request = Request::create('/', 'GET', [
        'page' => '1',
        'sort' => 'name',
    ]);

    $middleware = new CaptureUtmParameters();
    $middleware->handle($request, fn ($req) => $req);

    expect(session('page'))->toBeNull();
    expect(session('sort'))->toBeNull();
});

it('only stores configured keys', function () {
    $request = Request::create('/', 'GET', [
        'utm_source' => 'google',
        'utm_custom' => 'custom_value',
    ]);

    $middleware = new CaptureUtmParameters();
    $middleware->handle($request, fn ($req) => $req);

    expect(session('utm_source'))->toBe('google');
    expect(session('utm_custom'))->toBeNull();
});

it('passes request through to next handler', function () {
    $request = Request::create('/', 'GET');
    $called = false;

    $middleware = new CaptureUtmParameters();
    $response = $middleware->handle($request, function ($req) use (&$called) {
        $called = true;
        return $req;
    });

    expect($called)->toBeTrue();
});

it('does not overwrite existing session values when param not in request', function () {
    session(['utm_source' => 'existing_source']);

    $request = Request::create('/', 'GET', [
        'utm_medium' => 'cpc',
    ]);

    $middleware = new CaptureUtmParameters();
    $middleware->handle($request, fn ($req) => $req);

    expect(session('utm_source'))->toBe('existing_source');
    expect(session('utm_medium'))->toBe('cpc');
});

it('handles partial UTM params', function () {
    $request = Request::create('/', 'GET', [
        'utm_source' => 'newsletter',
    ]);

    $middleware = new CaptureUtmParameters();
    $middleware->handle($request, fn ($req) => $req);

    expect(session('utm_source'))->toBe('newsletter');
    expect(session('utm_medium'))->toBeNull();
    expect(session('utm_campaign'))->toBeNull();
});
