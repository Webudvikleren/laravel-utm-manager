# Laravel UTM Tracker

📈 Simple UTM tracking middleware for Laravel. Capture UTM parameters from the URL and make them easily accessible via session or helper methods. Great for tracking marketing sources across forms, registrations, or orders.

---

## ✨ Features

- Middleware to automatically store UTM parameters
- Configurable list of UTM keys
- Store in session (default) or extend for other storage
- Facade for easy access: `Utm::get('utm_source')`
- Optional trait for auto-filling UTM data on models

---

## 🔧 Installation

```bash
composer require webudvikleren/laravel-utm-manager
```

### Publish the config file:

```bash 
php artisan vendor:publish --tag=config --provider="Webudvikleren\UtmManager\UtmManagerServiceProvider"
```

## 🚀 Usage
### 1. Add middleware 

You can register the middleware globally or per route:

```bash
// app/Http/Kernel.php
protected $middleware = [
    // ...
    \Webudvikleren\UtmManager\Http\Middleware\CaptureUtmParameters::class,
];
```

Or assign it to specific routes:

```bash
Route::middleware(['utm.capture'])->group(function () {
    Route::get('/register', [RegisterController::class, 'show']);
});
```

### 2. Access UTM data

Use the facade to get stored UTM parameters:

```bash
use Utm;

Utm::get('utm_source'); // e.g., 'facebook'
Utm::all(); // returns all captured UTM data as array
```

### 3. Automatically attach UTM data to Eloquent models

Add the HasUtmData trait to your model:

```bash
use Webudvikleren\UtmManager\Traits\HasUtmData;

class Lead extends Model
{
    use HasUtmData;

    protected $fillable = [
        'name', 'email',
        'utm_source', 'utm_medium', 'utm_campaign',
    ];
}
```

When creating the model, UTM fields will be auto-filled (if present in the session).

## ⚙️ Configuration

```bash
// config/utm.php

return [
    'storage' => 'session',

    'utm_keys' => [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ],
];
```

## 📦 Example URL

Send traffic with UTM parameters to your app:

> https://yourapp.com/register?utm_source=facebook&utm_medium=social&utm_campaign=summer-sale

The package will capture and store these in the user's session.

## ✅ Roadmap Ideas

* Cookie support
* Database logging
* Integration with Laravel Nova or Horizon
* Debug toolbar for current UTM state

