---
layout: post
title: Hidden Laravel config env paths you might not know
tags:
    - laravel
---
Laravel has some interesting env config keys for storage and cache paths that aren't mentioned in the official documentation. Maybe you'll never need to customize them in your entire developer life, but I think knowing they exist is fun!

By default in your Laravel application, you usually have these folders:

- `bootstrap/cache`: *stores your application cached files such as routes, configs, events*
- `storage/`:  *stores compiled views, cache, session files, logs and upload files, etc*

For the storage folder in deployment, I actually create a folder outside the application and symlink it to the app, so we don't erase uploaded files every time we deploy. I think you do too.

But actually, if you look at the code in [Illuminate/Foundation/Application.php](https://github.com/laravel/framework/blob/72ea328b456ea570f8823c69f511583aa6234170/src/Illuminate/Foundation/Application.php), you can see there are some hidden env configs that may be useful sometimes.

## Customize storage path

You can modify the default storage path by calling `$app->useStoragePath($yourPath)` in `bootstrap/app.php`.

```php
public function useStoragePath($path)
{
    $this->storagePath = $path;

    $this->instance('path.storage', $path);

    return $this;
}
```

## Customize framework cache paths

Now take a look at this `normalizeCachePath` function. If the value starts with an absolute prefix like `/` or `\`, it will use an absolute path; otherwise, it will use a relative path.

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

And there are some hidden configs if you want to customize the `bootstrap/cache` folder. This is useful when you want to ship an application somewhere you don't have write permission in the application folder xD.

You can set values for these keys in the `.env` file:

- `APP_SERVICES_CACHE`
- `APP_PACKAGES_CACHE`
- `APP_CONFIG_CACHE`
- `APP_ROUTES_CACHE`
- `APP_EVENTS_CACHE`
