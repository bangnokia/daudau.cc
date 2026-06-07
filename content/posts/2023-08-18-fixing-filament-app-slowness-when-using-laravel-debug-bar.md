---
layout: post
title: Fixing Filament app slowness when using Laravel Debugbar
tags:
  - filament
  - laravel debugbar
  - laravel
---

By default, [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) enables view logging, which consumes a significant amount of resources in a Filament app. Displaying all view names can even cause Debugbar itself to crash rather than the application. Therefore, it is advisable to disable this feature unless you are specifically working on a custom field.

## Publishing the Laravel Debugbar Configuration File
To begin, execute the following command to publish the Laravel Debugbar config file:

```
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```

Next, navigate to the `config/debugbar.php` file and disable view logging by making the following adjustment:

```php
// ...
'views' => false,
// ...
```

That concludes the process. Enjoy a smoother development experience with Filament.
