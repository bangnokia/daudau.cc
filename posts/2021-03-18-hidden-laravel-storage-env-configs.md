---
title: Some hidden laravel storage env configs you don't know
layout: post
status: published
---

By default in your Laravel application, you ussually have those folders

- `bootstrap/cache`: stores your application cached files: routes, configs, events
- `storage/`:  stores compiled views, cache, session files, logs and upload files, etc

About storage folder when deployment, i acctually just create an folder outside of the application and make a symbol link to the app, so we dont erase out uploaded files every time we deploy, and i think you doo too.

But acctually if you look at code at [`Illuminate/Foundation/Application.php`](https://github.com/laravel/framework/blob/72ea328b456ea570f8823c69f511583aa6234170/src/Illuminate/Foundation/Application.php) you can see there are some hidden env configs maybe useful sometimes.

## Customize your storage path

You can modify default storage path in the `bootstrap/app.php` by calling `$app->useStoragePath($yourPath)`

```php
public function useStoragePath($path)
{
    $this->storagePath = $path;

    $this->instance('path.storage', $path);

    return $this;
}
```

Now take a look this function, if our value starts with any absolute prefixes `/` or `\`, so it will use absolute path, other wise relative path

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

## Customize framework cache paths

You can set values for these keys in the `.env` file

- `APP_SERVICES_CACHE`
- `APP_PACKAGES_CACHE`
- `APP_CONFIG_CACHE`
- `APP_ROUTES_CACHE`
- `APP_EVENTS_CACHE`

