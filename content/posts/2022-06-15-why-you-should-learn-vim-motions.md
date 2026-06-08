---
layout: post
title: Why you should learn Vim (motions)
tags:
  - vim
  - neovim
---
*Disclaimer: This post is not about convincing you to give up your lovely IDEs like VSCode or PhpStorm*

## The Vim journey is damn painful and exciting

I'm pretty sure lots of you have heard about Vim, a kind of alien text editor that is hard to learn and nobody wants to open. That's why lots of people search ["how to exit vim"](https://www.google.com/search?client=firefox-b-d&q=how+to+exit+vim) (including me) on Google.

![google search](https://i.imgur.com/8jh22TS.png)

"Vim" is a common term in my post. More accurately, I did try Vim, then switched to Neovim because it's more active and has lots of improvements.

Every Vim user has their own config file because you have to install lots of plugins to make it work (for you), and lots of keybindings to remember because using a mouse sucks, but that's the point. You just need to remember the stuff you use most, and your muscles will do it for you. Finally, you have your dream IDE, and no colleague wants to touch your IDE.

## I don't use Neovim anymore

My daily job is web development, and I also do lots of frontend stuff (Tailwind CSS, React, ...) in the macOS environment. Nowadays, PHP is growing so damn fast, and there isn't a good enough PHP language server. I also don't have time to configure my Neovim (of course I had to work hard because of low salary 🥲) to make it comparable to PhpStorm, so I installed [IdeaVim](https://plugins.jetbrains.com/plugin/164-ideavim), and that's all I need. For frontend stuff, I use VSCode with the [vscodevim](https://marketplace.visualstudio.com/publishers/vscodevim) extension.

I think macOS and Vim motions are the best combo, tho. Most keybindings on macOS use `Cmd` and Vim uses `Ctrl`, so it won't have many conflicts like on Windows and Linux.

## Treat Vim like a toolkit

If you don't know Vim, you are still ok, but if you know Vim, you have a powerful toolkit. Doesn't that sound great?

You don't have to use Vim as your daily code editor. You just need to know Vim motions, and they will help you a lot.

You're a coder, so most of the time you're writing code. When moving in Vim, you basically press `h`, `j`, `k`, `l`, and don't have to lift your right hand to press the arrow keys. Having to press arrow keys sucks. Using Vim, most of the time you jump between points in the editor instead of going line by line like traditional editors or scrolling with your mouse :( (how to do it, you need to find out yourself).

When you `ssh` into your Linux server and modify some configuration files, you can use `nano` and spam your arrow keys to move around your file. That's terrible. Vim is a savior with lots of no-brain keyboard shortcuts to save your time: `G`, `gg`, `C-f`, `C-b`, `dd`, `%`, `w`, `b`, ... You see, they are random bullshit keybindings, but they work 🤣.

Anyway, you can SSH into your production server and edit source code using Vim. That's real-time deployment 🔥.

If you know Vim, you can code in the terminal like a pro hacker with a black background; your female colleagues will love you.

So my combo is using some basic Vim motions in my editors. That's enough for me: I can quickly get support for the latest language and framework features (linting, validation, ...) via extensions and feel comfortable away from the mouse. Mark my words, the more you use Vim, the more you love it.
