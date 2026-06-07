---
layout: post
title: How to "tinker" with any PHP application
tags:
  - laravel
  - tinker
---
## Do you know Tinkerwell app?

If you are a Laravel developer, you may know a piece of software called [Tinkerwell](https://tinkerwell.app/) made by Marcel Pociot, the fast ~~boy~~ developer from [Beyond Code](https://beyondco.de/), which helps you tinker with any PHP application on your local machine or a remote server via SSH.

My first impression was: this is epic! What the hell, how does it work? **You should [buy](https://tinkerwell.app/#pricing) it**.

## How it works

> I haven't bought Tinkerwell or used it before (because US pricing isn't sweet in my country xD); all the explanations in this blog post come from investigating public resources for Tinkerwell and laravel-web-tinker.

My first thought was that it must be based on the `artisan tinker` command. So after digging into the Laravel Tinker component, I saw it's just a specific wrapper around [PsySH](https://github.com/bobthecow/psysh) - a runtime developer console, interactive debugger, and REPL for PHP. From there, the light turned on for us.

### Bootstrap a PHP application

First, we need to include the correct entry file of the application, which gives you access to all the functions of the project. For more details, you should take a look at the [configuration](https://github.com/bobthecow/psysh/wiki/Configuration) of PsySH.

For example, if a project is based on Composer, it is `vendor/autoload.php`. For Laravel, it is `bootstrap/app.php`; for WordPress, it is `wp-load.php`, etc.

### Execute PHP code

We have 2 problems to solve:

- Bootstrap a project on the local machine.
- Bootstrap a project on the remote server???

Including files on local machines is easy, but how can we include them on the remote server? The only action we can do is execute some commands via SSH.

Let's try to make a small binary file. We're going to upload it to the server, and of course, the file size must be as small as possible. So I made a simple wrapper for PsySH and named it [psycho](https://github.com/bangnokia/psycho), built using [box](https://github.com/box-project/box), and the file size is around ~600KB - ok fine :(. It also uses drivers to detect and properly bootstrap **many** kinds of PHP projects (actually 2).

The API is simple:

```bash
php psycho.phar --target=/project/root/path --code=somephpcode
```

![a cute cat do programming](https://i.imgur.com/DE9TIBw.png)

A cute cat does programming.

My naming for classes in this package is stupid, and you should not use it.

### Strategies

We need to install PHP on our machine.

On the local machine, we spawn a process and execute the `psycho.phar`.

On the remote server, we can upload `psycho.phar` to the `/tmp/` directory and execute the command via SSH:

```bash
ssh user@remote.test "psycho command"
```

IMHO, if we can open a background process, keep the SSH session connected, and stream the output, that's a better way than SSHing into the server every time we execute PHP code. But I don't know how to do it. If you know, please give me some clues :(.

## Proof of Concept

I already made an Electron app like Tinkerwell with basic functions, and it works **for me**. It's called [Pinker](https://github.com/bangnokia/pinker).

Pinker itself is a Laravel app. Why? Because shipping a default Laravel project is convenient for quickly prototyping pieces of code, so I wrote it in Laravel. The Electron part helps spawn `php artisan serve` and opens the local URL. Thankfully, Laravel Livewire made it feel like a SPA easily, and I don't like to write much JavaScript stuff.

So maybe you can try it or make your own version if you are a *hardcore* and *poor* guy. My worst experience with Electron is that the file size after building is ridiculously big (around ~90MB).

## Conclusion

Again, this research does not describe how Tinkerwell actually works; all the plots came from my imagination. I just want to use some very basic functions daily.

Making an application like Tinkerwell needs a lot of hard work, so you should consider buying it for the best experience.

Thank you for reading my dummy explanations. Hope you guys enjoy it!
