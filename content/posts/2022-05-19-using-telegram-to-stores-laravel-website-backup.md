---
layout: post
title: Using Telegram to stores Laravel website backup
tags:
  - laravel
  - backup
  - telegram
---
When you're running some websites, I'm sure you gonna face the backup problem. I'm using Digital Ocean, backup service comes with extra cost, and I'm poor.

My mostly websites are running with Laravel, and there is an awesome package Spatie called [Laravel backup](https://github.com/spatie/laravel-backup). What you need to do is just set a schedule command `backup:run` running daily, it's will automatically back up your database, and even directories

By default, it stores your backup files on the server (the default disk driver is local, and I don't use s3), this is nonsense because if your server dies, everything will be gone. In my case, most of my sites don't use much storage, the only thing important to me is the database, so I only backup the database 😂.

My backup files with gzip are only a few MBs or some, there doesn't big even if your database has a few million rows. Telegram has awesome APIs, and the bot is great, you can create a group, add your bot and upload your backup file here using  [sendDocument](https://core.telegram.org/bots/api#senddocument), and totally free, and comes with awesome notification 😂. When you need an old backup, open the Telegram and download it, lol. The only limitation is file size must be less than 50MB.
![](https://i.imgur.com/lF4SiP3.png)

So I create this simple package [Laravel backup telegram](https://github.com/bangnokia/laravel-backup-telegram) which is just a plugin of `spatie/laravel-backup`, it listens to the event when the backup process was successful, then upload the file to the telegram group chat. It's actually simple but helped me a lot. If you have a backup problem like me, hope you enjoy it!