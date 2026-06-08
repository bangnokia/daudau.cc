---
layout: post
title: Laravel live reloading without any JS stuff
tags:
    - laravel
    - reactphp
    - live reload
---
Did you know we can implement live reload in Laravel without any npm package? No `browser-sync`, no Node.js, just PHP.

Small confession: I don't like Node.js xD, and I don't know Node.js either xD. And if you've read this far, you got clickbaited xD; we actually need a bit of JavaScript. Sometimes when working with Laravel Livewire, live reloading is really helpful, and I don't feel good if I have to install something like BrowserSync or other JS stuff. So let's do it with PHP.

## How live reloading works

![live-reloading-sketch.png](https://i.imgur.com/vTX65xy.png)

First, we need a [WebSocket server](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API/Writing_WebSocket_servers), but we don't have to write it ourselves, thanks to [ReactPHP](https://reactphp.org/) and [Ratchet](http://socketo.me/).

In the browser, something needs to listen to the WebSocket server and reload the page when the server tells it to.

Finally, we also need a file watcher. It watches for file changes while we edit the project, then asks the WebSocket server to send a command to browser clients to reload the URL.

## Laravel package implementation

My goal is to integrate it into the `php artisan serve` command. I think it's convenient and simple to use.

So I overwrote the [ServeCommand](https://github.com/bangnokia/laravel-serve-livereload/blob/84d9689444652ca8ab687e74b5c7bf65e04696b0/src/Commands/ServeCommand.php) class. This command now spawns 2 processes:

- The default `artisan serve` from Laravel, which now becomes `artisan serve:http`.
- The WebSocket server `artisan serve:websockets`.

The customization magic actually comes from the `serve:websockets` command. It also spawns a file watcher that checks for file changes every 500ms, triggers the reload command on the WebSocket server, and sends it to all listening clients.

The file watcher also does a silly task: writing a cache value.

```php
Cache::put('serve_websockets_running', true, 5);
```

This helps us detect whether the WebSocket server is running. I think 5 seconds is okay. So we can inject the script into the HTML response via Laravel middleware. It just puts the script at the very beginning of the HTML response. It doesn't look nice, but it works.

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

And this is my [laravel-server-livereload](https://github.com/bangnokia/laravel-serve-livereload) package. Thank you for reading my explanation.
