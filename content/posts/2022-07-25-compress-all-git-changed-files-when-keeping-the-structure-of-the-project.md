---
layout: post
title: Compress all git changed files while keeping the project structure
tags:
  - git
---
Sometimes I do freelance jobs, and I have some clients who don't use `git`. They send me the source code and database, then I need to send all the modified files back to them.

As a developer, when I receive the source code, I create an initial commit and switch to another branch to work on it. So I can upload it to my personal GitHub and easily track changed files via pull request.

![](https://i.imgur.com/9NbGO0g.png)

Then, after the work is done, I have to send files back to the clients. It doesn't make sense to send all project files; they also want to know which files were modified.

This command actually saves my life and saves me from copying every file into the corresponding folder structure before sending it to clients like I did in the past, lol.

```bash
tar -vczf changed.tar $(git diff-tree -r --no-commit-id --name-only --diff-filter=ACMRT main dev)
```

I'm not the author of this command; I copied it from [here](https://gist.github.com/hnq90/7078e0d432cd29cff2daf03207708948) xD.
