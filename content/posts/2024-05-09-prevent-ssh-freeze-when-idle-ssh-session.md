---
title: Prevent SSH from freezing during idle sessions
tags:
    - ssh
layout: post
---

I had a problem with my SSH session. It always froze when I left it idle for a while, and I had to close the terminal and open a new one to reconnect. It's very annoying, so I decided to find a solution.

This happens because the server closes the connection after it's been idle for a while, so we need to send a keep-alive signal to prevent the server from closing the connection.

On macOS, you can edit `~/.ssh/config` and add this line:

```bash
ServerAliveInterval 60
```

This will send a keep-alive signal to the server every 60 seconds, so the server won't close the connection.
