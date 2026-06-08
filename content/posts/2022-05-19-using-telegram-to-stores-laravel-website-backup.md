---
layout: post
title: Using Telegram to store Laravel website backups
tags:
  - laravel
  - backup
  - telegram
---
When you're running websites, I'm sure you're gonna face a backup problem. I'm using DigitalOcean; the backup service comes at an extra cost, and I'm poor.

Most of my websites run on Laravel, and there is an awesome Spatie package called [Laravel Backup](https://github.com/spatie/laravel-backup). All you need to do is schedule the `backup:run` command to run daily. It will automatically back up your database, and even directories.

By default, it stores your backup files on the server (the default disk driver is local, and I don't use S3). This is nonsense because if your server dies, everything will be gone. In my case, most of my sites don't use much storage; the only thing important to me is the database, so I only back up the database 😂.

My gzipped backup files are only a few MB or so; they aren't big even if the database has a few million rows. Telegram has awesome APIs, and bots are great. You can create a group, add your bot, and upload your backup file there using [sendDocument](https://core.telegram.org/bots/api#senddocument). It's totally free and comes with awesome notifications 😂. When you need an old backup, open Telegram and download it, lol. The only limitation is that the file size must be under 50MB.
![](https://i.imgur.com/lF4SiP3.png)

So I created this simple package, [Laravel backup telegram](https://github.com/bangnokia/laravel-backup-telegram), which is just a plugin for `spatie/laravel-backup`. It listens to the event when the backup process succeeds, then uploads the file to the Telegram group chat. It's actually simple but helped me a lot. If you have a backup problem like me, hope you enjoy it!
