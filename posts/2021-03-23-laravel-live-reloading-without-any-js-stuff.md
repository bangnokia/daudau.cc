---
title: Laravel live reloading without any js stuff
tags: laravel, reactphp, live reload
---
Do you know that we can implement live reload in Laravel without any npm package? No `browser sync`, `no nodejs`, just `php`.

Self claim, I don't like NodeJS xD, and I don't know NodeJS too xD. And if you read to here, you got clickbait xD, we actually need a bit of javascript. Sometimes working with laravel livewire, live reloading is really helpful, and I don't feel good if I have to install something like browser sync or some js stuff. So let's do it with PHP

## How live reloading works

![live-reloading-sketch.png](https://i.imgur.com/vTX65xy.png)

First, we need a [WebSocket server](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API/Writing_WebSocket_servers), but we don't have to write it by ourselves, thankfully [ReactPHP](https://reactphp.org/) and [Rachet](http://socketo.me/).

And in the browser, somehow it needs to listen to the WebSocket server, and reload the browser when the server told it to do.

Finally, we also need file watchers, it watches the files changing when we edit the project, then asks the WebSocket server to send a command to the WebSocket client in the browser force him to reload the URL.

## Laravel package implementation

My purpose is to integrate it into the `php artisan serve` command, I think it's convenient and simple to use.

So I overwrote the [ServeCommand](https://github.com/bangnokia/laravel-serve-livereload/blob/84d9689444652ca8ab687e74b5c7bf65e04696b0/src/Commands/ServeCommand.php) class. This command now spawns 2 processes:

- The default `artisan serve` from laravel, which now become `artisan serve:http`.
- The WebSocket server `artisan serve:websockets`.

The customization magic actually comes from `server:websockets` command. It's also spawned a file watcher, which watches files changing every 500ms and triggers the reload command to the WebSocket server, then sent to all the listener clients.

And the file watcher also does a stupid task is writing a cache parameter

```php
Cache::put('serve_websockets_running', true, 5);
```

This can help us detect is that the WebSocket server is running or not. I think 5 seconds is ok. So we can inject the script to the HTML response via laravel middleware. Just put it at the very beginning of HTML response, doesn't look good but it works.

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

And this is [laravel-server-livereload](https://github.com/bangnokia/laravel-serve-livereload) package. Thank you for reading my explanation.