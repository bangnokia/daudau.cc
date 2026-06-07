---
layout: post
title: Install PHP mcrypt extension on macOS
tags:
  - php
  - macos
  - mcrypt
---
Sometimes you upgrade a legacy project that requires an old, deprecated extension like `mcrypt`. This extension doesn't come with PHP by default, so we have to install it via `pecl`.

```bash
pecl install mcrypt
```

Unfortunately, it doesn't work on my computer, and it keeps displaying this annoying error:
```
configure: error: mcrypt.h not found. Please reinstall libmcrypt.
```

So I found the solution on [StackOverflow](https://stackoverflow.com/a/67761346) and decided to copy the command and write it here.

You can try this to save time when you have no idea what to do:

```bash
pecl install mcrypt <<<"$(ls -d $(brew --prefix)/Cellar/mcrypt/* | tail -1)"
```
