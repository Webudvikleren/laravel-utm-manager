# Laravel UTM Manager

📈 Simple UTM tracking middleware for Laravel. Capture UTM parameters from the URL and make them easily accessible via session or helper methods. Great for tracking marketing sources across forms, registrations, or orders.

---

## ✨ Features

- Middleware to automatically store UTM parameters
- Configurable list of UTM keys
- Store in session (default) or extend for other storage
- Facade for easy access: `Utm::get('utm_source')`
- Trait for auto-filling UTM data directly on Eloquent models
- Trait for attaching UTM data to a related model (`utmVisit`)
- Artisan command to generate a migration dynamically

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

### 4. Store UTM data in a related model
If you want to store UTM data in a separate model (e.g., `utm_visits`), use the `HasUtmRelation` trait:

```bash
use Webudvikleren\UtmManager\Traits\HasUtmRelation;

class User extends Model
{
    use HasUtmRelation;

    public function utmVisit()
    {
        return $this->hasOne(\App\Models\UtmVisit::class);
    }
}
```

Then define the related model like this:

```bash
class UtmVisit extends Model
{
    protected $table = 'utm_visits'; // or load from config('utm.table')

    protected $fillable = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

The related model class and table name are both configurable via `config/utm.php`.

### 5. Generate a migration for related UTM data
The package includes an Artisan command to generate a migration based on the configured UTM keys and table name.

```bash
php artisan utm:make-migration
php artisan migrate
```

This will generate a migration with the correct user_id foreign key and all defined UTM columns.

### 6. Publish the default UtmVisit model

To create a prebuilt `UtmVisit` model in your `app/Models` folder:

```bash
php artisan utm:publish-model
````

You can then customize the model or change the class in `config/utm.php`.

## ⚙️ Configuration

```bash
// config/utm.php

return [

    // Where to store UTM data: 'session' (default)
    'storage' => 'session',

    // Which UTM keys to track
    'utm_keys' => [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ],

    // Table name for storing UTM visits (if using HasUtmRelation)
    'table' => 'utm_visits',

    // Fully qualified class name for related UTM model
    'related_model' => \App\Models\UtmVisit::class,
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

