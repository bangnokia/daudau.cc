---
title: Prevent SSH freeze when idle SSH session
tags:
    - ssh
layout: post
---

I have a problem with my SSH session, it always freezes when I leave it idle for a while, and I have to close the terminal and open a new one to reconnect. It's very annoying, so I decided to find a solution for this.

This happens because the server closes the connection when it's idle for a while, so we need to send a keep-alive signal to the server to prevent it from closing the connection.

On MacOS, you can edit this file `~/.ssh/config` and add this line:

```bash
ServerAliveInterval 60
```

This will send a keep-alive signal to the server every 60 seconds, so the server will not close the connection.