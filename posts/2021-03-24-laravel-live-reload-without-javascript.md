---
title: Laravel live reloading without any js stuff
layout: post
status: published
tags[]: laravel, reactphp, live reload
---

Do you know that we can implement live reload in Laravel without any npm package. No `browser sync`, `no nodejs`, just `php`.

Self claim, i don't like nodejs xD, and i don't know nodejs too xD. And if you read to here, you got click bait xD, we actually need a bit javascript. Sometimes working with laravel livewire, live reloading is really helpful, and i don't feel good if i have to install something like browsersync or some js stuff. So let do it with PHP

## How live reloading works {#how-live-reloading-works}

First we need a [websocket server](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API/Writing_WebSocket_servers), but we don't have to write it by ourself, thankfully [ReactPHP](https://reactphp.org/) and [Rachet](http://socketo.me/).

And in browser, some how it need to listen the websocket server, and reload the browser when the server told it to do.

Finally we also need file watchers, it watchs the files changing when we editing project, then tell websocket server send command tell the websocket client in browser reloads the url.

## Laravel package implementation {#laravel-packge-implementation}

My purpose is integrate in the the `php artisan serve` command, i think it's convenient and simple to use.

So i overwrite the [ServeCommand](https://github.com/bangnokia/laravel-serve-livereload/blob/84d9689444652ca8ab687e74b5c7bf65e04696b0/src/Commands/ServeCommand.php) class. This command now spawn 2 processes:

- The default `artisan serve` from laravel, which now be `artisan serve:http`.
- The websocket server `artisan serve:websockets`.

The customization actually comes from `server:websockets` command. It's also spawn a file watcher, it watchs files changing every 500ms, and trigger the reload command to websocket server, then sending to all the listening clients.

And the file watcher also do a stupid task is writing a cache parameter

```php
Cache::put('serve_websockets_running', true, 5);
```

This can help us detect is that websocket server is running or not. I thin 5 seconds is ok. So we can inject the script to the html response via laravel middleware. Just put at the very begining of html response, doesn't look good but it works.

```php
public function injectScripts($content)
{
    $content = (string) view('serve_livereload::script', [
        'host' => '127.0.0.1',
        'port' => ServeWebSocketsCommand::port(),
    ]).$content;

    return $content;
}
```

And this is [laravel-server-livereload](https://github.com/bangnokia/laravel-serve-livereload) package. Thank you for reading my explaination.

