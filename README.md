# daudau.cc

Billy Nguyen's personal blog and project portfolio, live at [daudau.cc](https://daudau.cc). Articles cover web development, Laravel, infrastructure, and lessons from building personal projects.

Built with [Lina](https://lina.daudau.cc), a PHP static site generator. Markdown content and Blade templates compile into HTML. The deployed site needs no PHP runtime or database, and there is no Node.js build step.

## Local development

Requirements: PHP 8.3 or newer with the `pcntl` extension, and Composer. Composer checks the remaining dependency and extension requirements during installation. On Windows, use WSL for `pcntl` support.

```bash
composer install
composer dev
```

Open the address printed in the terminal, normally `http://127.0.0.1:6969`. Lina starts the development server and live reload. Stop it with `Ctrl+C`.

The equivalent direct command is `./vendor/bin/lina serve`.

## Project structure

| Location | Purpose |
| --- | --- |
| `content/posts/` | Blog posts written in Markdown with YAML front matter |
| `content/` | Homepage, About, Projects, Wakatime, and 404 page content |
| `resources/views/` | Blade layouts for the homepage, posts, and standalone pages |
| `resources/views/components/` | Dates, tags, comments, and theme toggle |
| `public/style.css` | Site styles, typography, and light/dark themes |
| `public/images/`, `public/fonts/` | Static assets |
| `public/` | Generated HTML alongside the static assets |
| `resources/cache/` | Generated template cache |

Edit Markdown and Blade sources rather than generated HTML. `public/.gitignore` excludes build output while keeping the site's styles and assets tracked.

## Write a post

Create `content/posts/YYYY-MM-DD-my-post-title.md`:

```markdown
---
title: My post title
layout: post
description: A short summary for search results and link previews.
tags:
    - development
    - laravel
---

Start the article here. The template already renders the title as an H1.

## First section

Write Markdown, including links, lists, and fenced code blocks.
```

Lina reads the publication date from the filename and uses the remaining name as the URL slug. This example appears at `/posts/my-post-title`. The homepage lists posts automatically, newest first.

Put article images in `public/images/` and reference them as `![Descriptive alt text](/images/example.png)`. The post template uses the first article image as its social preview image; otherwise, the shared layout falls back to a title-based image service.

For a standalone page, create a file such as `content/example.md` with `title` and `layout: page` in its front matter. It will appear at `/example`. Add a navigation link in `resources/views/layout.blade.php` if needed.

## Frontend features

- Light and dark themes, with the preference stored in the browser.
- Internal link prefetching and JavaScript navigation with browser history support.
- Blog comments through [Utterances](https://utteranc.es), backed by issues in `bangnokia/daudau.cc`.
- Google Analytics and social preview metadata in the shared layout.
- An additional `/wakatime` page with embedded coding activity charts.

## Build and deploy

```bash
composer build
```

This runs `./vendor/bin/lina build` and writes the static site to `public/`. Upload that directory to a static host that supports extensionless page URLs, such as `/about` serving `about.html`.

The repository includes two deployment helpers:

- `.github/workflows/deploy.yml` builds and publishes `public/` to GitHub Pages when the `lina` branch is pushed. It currently installs the older `bangnokia/lina:dev-main` package globally, while local development uses `linaphp/lina:^0.6` from Composer. A push to `main` does not trigger this workflow.
- `cloudflare-page.sh` is a Linux build helper that downloads PHP 8.3.4 and the latest Lina PHAR, then builds the site. For Cloudflare Pages, its build command is `bash cloudflare-page.sh` and the output directory is `public`.

These helpers use different Lina dependency sources; `composer install` followed by `composer build` uses this repository's lockfile. Hosting dashboard settings are configured outside the repository.

Before publishing, run `composer build` and preview the affected pages locally. Check article formatting, images, navigation, and both themes.
