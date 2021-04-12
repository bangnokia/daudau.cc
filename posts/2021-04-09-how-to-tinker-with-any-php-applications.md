---
title: How to "tinker" with any PHP applications
layout: post
status: published
tags[]: laravel, tinker
---

## Do you know Tinkerwell app? {#do-you-know-tinkerwell-app}

If you a Laravel devloper, i think you may be known a software called [Tinkerwell](https://tinkerwell.app) made by Marcel Pociot, the fast ~~boy~~ developer from [Beyond Code](https://beyondco.de/), which help you tinker with any PHP applications even on local machine or remote server via SSH.

You know, the first impression, that was epic! What the hell how it works? **You should [buy](https://tinkerwell.app/#pricing) it**.

## How it works {#how-it-works}

> I haven't buy the Tinkerwell or used it before (because US pricing isn't sweetly in my country xD), all the explainations in this blog post from some investigations about [public resources](https://github.com/tinkerwellapp/drivers) of Tinkerwell and [laravel-web-tinker](https://github.com/spatie/laravel-web-tinker)

My first thought, it's must be something base on `artisan tinker` command. So after digging into laravel tinker component, i see it's just an specific wrapper of [PsySH](https://github.com/bobthecow/psysh) - a runtime developer console, interactive debugger and REPL for PHP. From row, the light is openned for us.

### Bootstraps PHP application {#bootstraps-php-application}

First, we need to includes the correctly entry files of the application, which give you access to all then functions of the project. For more details, you should take a look at the [configuration](https://github.com/bobthecow/psysh/wiki/Configuration) of PsySH.

Example if project base on composer, it is `vendor/autoload.php`. For laravel is `bootstrap/app.php`, Wordpress is `wp-load.php`, etc...

### Executes php code {#execute-php-codes}

We have 2 problems to solve:

- Bootstrap for project on local machine.
- Bootstrap for project on remote server???

Including files on local machines is easy, but how can we includes them on the remote server? The only action we can do is execute some commands via SSH.

Let try to make a small binary file, we gonna upload it to server, and of course the file size must be small as possible. So i made a simple wrapper for PsySH and named it [psycho](https://github.com/bangnokia/psycho), built using [box](https://github.com/box-project/box) and the file  size around ~600kb - ok fine :(. It's also using drivers to detects and proper bootstraps **many** kinds of php project (actually 2).

The api is simple:

```bash
php psycho.phar --target=/project/root/path --code=somephpcode
```

![pinker sketch](/images/pinker-sketch.png)
<p align="center"><i>a cute cat do php programming</i></p>

My naming for classes in this package is stupid, and you should not use it.

### Strategies {#strategies}

Absolutely, we need install PHP on our machine.


On local machine, we spawn a process an execute the `psycho.phar`.

On remote server, we can upload `psycho.phar` to `/tmp/` directory and execute command via SSH: 
```
ssh user@remote.test "psycho command"
```
IMHO if we can open a background process and keep the connection of the ssh session then streamming the out output, that's actually better way than having to ssh into server every time we execute php code, but i don't know how to do it. If you know, please give me some clues :(.

## Proof of Concept {#poc}

I already made a electron app like Tinkerwell with base functions, and it works **for me**. It's called [Pinker](https://github.com/bangnokia/pinker).

Pinker itself is a Laravel app, why? Because shipping the default Laravel project is convenient for quick prototyping some pieces of code, let write it in Laravel. So electron part help spawns `php artisan serve` and open the local url. Thankfully Laravel Livewire for crafted it up like a SPA, you know, easily and i don't like to write must javascript stuff.

So may be you can try it or made your own version if you a *hardcore* and *poor* guy. My worse experience with Electron is file size after built ridiculous big (around ~90MB).

## Conclusion {#conclusion}

Again, this research is not how Tinkerwell actually works, all the plots came from my illusion. I just want to use some very basic functions for my daily basis. 

To made a application like Tinkerwell really need so much hard working time, you should consider to buy it for best experience.

Thank you for reading my dummy explainations. Hope you guys enjoy it!
