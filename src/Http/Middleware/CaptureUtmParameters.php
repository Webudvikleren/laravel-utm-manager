<?php

namespace Webudvikleren\UtmManager\Http\Middleware;

use Closure;

class CaptureUtmParameters
{
    public function handle($request, Closure $next)
    {
        foreach (config('utm.utm_keys') as $key) {
            if ($request->has($key)) {
                session([$key => $request->get($key)]);
            }
        }

        return $next($request);
    }
}
