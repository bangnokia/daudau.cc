---
title: Laravel live reloading without any npm package
layout: post
status: draft
---

Do you know that we can implement live reload in Laravel without any npm package. No `browser sync`, `no nodejs`, just `php`.

Self claim, i don't like nodejs xD, and i don't know nodejs too xD. And if you read to here, you got click bait xD.

# How live reloading works {#how-live-reloading-works}

First we need a [websocket server](https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API/Writing_WebSocket_servers), but we don't have to write it by ourself, thankfully [ReactPHP](https://reactphp.org/) and [Rachet](http://socketo.me/).

And in browser, some how it need to listen the websocket server, and reload the browser when the server told it to do.

Finally we also need file watchers, it watchs the files changing when we editing project, then tell websocket server send command tell the websocket client in browser reloads the url.

# Laravel implement

My purpose is integrate in the the `php artisan serve` command, i think it's convenient and simple to use.

