---
title: Hidden laravel config env paths maybe you don't know
layout: post
status: published
tags[]: laravel
---

There are some interesting env config keys of Laravel didn't mention in official documentation about storage path and cache path. May be you will never need to custom them in you entire developer life, but i think just know their existence, it's fun!

By default in your Laravel application, you ussually have those folders:

- `bootstrap/cache`: *stores your application cached files such as routes, configs, events*
- `storage/`:  *stores compiled views, cache, session files, logs and upload files, etc*

About storage folder when deployment, i acctually just create an folder outside of the application and make a symbol link to the app, so we dont erase out uploaded files every time we deploy, and i think you doo too.

But acctually if you look at code at [`Illuminate/Foundation/Application.php`](https://github.com/laravel/framework/blob/72ea328b456ea570f8823c69f511583aa6234170/src/Illuminate/Foundation/Application.php) you can see there are some hidden env configs maybe useful sometimes.

## Customize storage path

You can modify default storage path  by calling `$app->useStoragePath($yourPath)` in the `bootstrap/app.php`.

```php
public function useStoragePath($path)
{
    $this->storagePath = $path;

    $this->instance('path.storage', $path);

    return $this;
}
```

## Customize framework cache paths

Now take a look at this `normalizeCachePath` function, if our value starts with any absolute prefixes `/` or `\`, so it will use absolute path, other wise relative path.

```php
protected function normalizeCachePath($key, $default)
{
    if (is_null($env = Env::get($key))) {
        return $this->bootstrapPath($default);
    }

    return Str::startsWith($env, $this->absoluteCachePathPrefixes)
            ? $env
            : $this->basePath($env);
}
```

And there are some hidden config if you want to customize the `bootstrap/cache` folder. This will useful when use want to ship application in some where you don't  have write permission in the application folder xD.

You can set values for these keys in the `.env` file:

- `APP_SERVICES_CACHE`
- `APP_PACKAGES_CACHE`
- `APP_CONFIG_CACHE`
- `APP_ROUTES_CACHE`
- `APP_EVENTS_CACHE`

