---
title: Compress all git changed files when keeping the structure of the project
tags: git
---
Sometimes I do freelance jobs, and I have some clients people who don't use `git`, they send me the source code and database, then I need to send back to them all the modified files.

As a developer, when I received the source code, I create an initial commit and switch to another branch to work on it. So I can upload it to my personal GitHub, and easily track changed files via pull request.

![](https://i.imgur.com/9NbGO0g.png)

Then after the work is done, I have to send files back to the clients. It's nonsense about sending all the files of the project, they also want to know which files had been modified too.

And this command actually saves my life and makes it easier away from coping every file and putting in the corresponding folder structure to send to the clients like me in the past, lol

```bash
tar -vczf changed.tar $(git diff-tree -r --no-commit-id --name-only --diff-filter=ACMRT main dev)
```

I'm not the author of this command, I copied it from [here](https://gist.github.com/hnq90/7078e0d432cd29cff2daf03207708948) xD.