<?php

namespace Webudvikleren\UtmManager;

class UtmManager
{
    public function get(string $key): ?string
    {
        return session($key);
    }

    public function all(): array
    {
        return collect(config('utm.utm_keys'))
            ->mapWithKeys(fn($key) => [$key => session($key)])
            ->toArray();
    }
}
