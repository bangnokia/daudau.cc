---
layout: post
title: How to "tinker" with any PHP applications
tags:
  - laravel
  - tinker
---
## Do you know Tinkerwell app?

If you are a Laravel developer, I think you may be known software called [Tinkerwell](https://tinkerwell.app/) made by Marcel Pociot, the fast ~~boy~~ developer from [Beyond Code](https://beyondco.de/), which helps you tinker with any PHP applications even on the local machine or remote server via SSH.

You know, the first impression, that was epic! What the hell is how it works? **You should [buy](https://tinkerwell.app/#pricing) it**.

## How it works

> I haven't bought the Tinkerwell or used it before (because US pricing isn't sweetly in my country xD), all the explanations in this blog post from some investigations about public resources of Tinkerwell and laravel-web-tinker
>

My first thought, was it must be something based on the `artisan tinker` command. So after digging into the Laravel tinker component, I see it's just a specific wrapper of [PsySH](https://github.com/bobthecow/psysh) - a runtime developer console, interactive debugger, and REPL for PHP. From row, the light is opened for us.

### Bootstraps PHP application

First, we need to include the correct entry files of the application, which give you access to all the functions of the project. For more details, you should take a look at the [configuration](https://github.com/bobthecow/psysh/wiki/Configuration) of PsySH.

For example, if a project is based on the composer, it is `vendor/autoload.php`. For Laravel is `bootstrap/app.php`, WordPress is `wp-load.php`, etc...

### Executes PHP code

We have 2 problems to solve:

- Bootstrap for a project on the local machine.
- Bootstrap for a project on the remote server???

Including files on local machines is easy, but how can we include them on the remote server? The only action we can do is execute some commands via SSH.

Let's try to make a small binary file, we gonna upload it to the server, and of course, the file size must be small as possible. So I made a simple wrapper for PsySH and named it [psycho](https://github.com/bangnokia/psycho), built using [box](https://github.com/box-project/box), and the file size around ~600kb - ok fine :(. It's also using drivers to detect and properly bootstraps **many** kinds of PHP projects (actually 2).

The api is simple:

```bash
php psycho.phar --target=/project/root/path --code=somephpcode
```

![a cute cat do programming](https://i.imgur.com/DE9TIBw.png)

a cute cat does programming

My naming for classes in this package is stupid, and you should not use it.

### Strategies

We need to install PHP on our machine.

On the local machine, we spawn a process and execute the `psycho.phar`.

On the remote server, we can upload `psycho.phar` to the `/tmp/` directory and execute the command via SSH:

```bash
ssh user@remote.test "psycho command"
```

IMHO if we can open a background process and keep the connection of the ssh session then stream the out output, that's a better way than having ssh into the server every time we execute PHP code, but I don't know how to do it. If you know, please give me some clues :(.

## Proof of Concept

I already made an electron app like Tinkerwell with base functions, and it works **for me**. It's called [Pinker](https://github.com/bangnokia/pinker).

Pinker itself is a Laravel app, why? Because shipping the default Laravel project is convenient for quick prototyping some pieces of code, let's write it in Laravel. So the electron part help spawns `php artisan serve` and open the local URL. Thankfully Laravel Livewire crafted it up like a SPA, you know, easily and I don't like to write must javascript stuff.

So maybe you can try it or make your version if you are a *hardcore* and *poor* guy. My worse experience with Electron is file size after building ridiculous big (around ~90MB).

## Conclusion

Again, this research is not how Tinkerwell works, all the plots came from my illusion. I just want to use some very basic functions on a daily basis.

To make an application like Tinkerwell need so much hard-working time, you should consider buying it for the best experience.

Thank you for reading my dummy explanations. Hope you guys enjoy it!