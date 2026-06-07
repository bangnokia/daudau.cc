---
title: Add a user to the sudo group without a password when switching on Ubuntu
tags:
    - ubuntu
layout: post
---

This is a quick note on how to add a user to the sudo group without a password when switching on Ubuntu.
It really annoys me when I have to type the password every time I switch to the root user (I almost cannot remember the password).

If you need to add a user to the sudo group without a password when switching, you can follow these steps:

1. Open the sudoers file with the command: (You need root permission to do this)

```bash
sudo visudo
```

2. Add the following line to the end of the file:

```bash
username ALL=(ALL) NOPASSWD: ALL
```

Replace `username` with your username.

