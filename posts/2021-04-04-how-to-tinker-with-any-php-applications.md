---
title: How to "tinker" with any PHP applicatons
layout: post
status: draft
tags[]: laravel, tinker
---

## Do you know Tinkerwell app? {#do-you-know-tinkerwell-app}

If you a Laravel devloper, i think you may be known a software called [Tinkerwell](https://tinkerwell.app) made by Marcel Pociot, the fast ~~boy~~ developer from [Beyond Code](https://beyondco.de/), which help you tinker with any PHP applications even on local machine or remote server via SSH.

You know, the first impression, what the hell how it works? That was epic! You should buy it.

## How it works {#how-it-works}

> I didn't buy the Tinkerwell or used it to disassemble the (because i don't have money xD). All the explainations in this blog post from some investigations about [public resources](https://github.com/tinkerwellapp/drivers) of Tinkerwell and [laravel-web-tinker](https://github.com/spatie/laravel-web-tinker)

My first thought, it's must be something base on `artisan tinker` command. So after digging into laravel tinker component, i see it's just an specific wrapper of [PsySH](https://github.com/bobthecow/psysh) - a runtime developer console, interactive debugger and REPL for PHP.

### Bootstraps PHP application {#bootstraps-php-application}
