---
layout: post
title: Install PHP mcrypt extension on macOS
tags:
  - php
  - macos
  - mcrypt
---
Sometimes you upgrade the legacy project, which requires some old extension that is already deprecated like `mcrypt`.   This extension doesn't come with PHP by default, so we have to install it via `pecl`

```bash
pecl install mcrypt
```

Unfortunately, it doesn't work on my computer, and keeps displaying this annoying error:
```
configure: error: mcrypt.h not found. Please reinstall libmcrypt.
```

So I found the solution on [StackOverflow](https://stackoverflow.com/a/67761346) and decided to copy the command and write it here.

You could  try this to save lots of time about having no idea what to do

```bash
pecl install mcrypt <<<"$(ls -d $(brew --prefix)/Cellar/mcrypt/* | tail -1)"
```