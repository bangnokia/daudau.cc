---
title: How we handle 1000 Laravel websites on a single server
layout: post
tags:
    - laravel
    - caddy
---

*Discover how we scaled from 280 to Although we've achieved significant resource savings and streamlined our deployment process, there are still areas we plan to improve:
- **Monitoring**: We're exploring tools like Prometheus or Grafana to aggregate important metrics across all stores. This will help us identify bottlenecks quickly.
- **Scaling Strategy**: If traffic spikes, we'll consider page caching. We won't use cloud solutions or auto-scaling—that would make us broke 😂.r 1000 Laravel websites on a single server with resource optimizations, deployment tricks, and multi-tenant magic.* 🚀

From the early days, we've been using Laravel to build ecommerce websites for selling products online. Laravel serves as our storefront for rapid development.

We use [lunarphp](https://lunarphp.io/) for ecommerce functionality. It's a Laravel package that provides comprehensive features for online stores.

For each product type, we deploy a new website. So we have many stores running on a few servers.

## Our Tech Stack Before
- Nginx as web server
- Let's Encrypt for SSL (certbot)
- PHP-FPM as PHP processor (We use PHP 8.2 until now)
- MySQL as database
- Redis for queue
- File caching for sure (Redis slow as f*ck) 😂
- Server running on Ubuntu 22.04
- Ansible and Jenkins for CI/CD
- GitHub for version control (of course) 🫠

To create a new store, we run the Ansible playbook in Jenkins. Everything is automated so we can focus on developing the store—simple and efficient.

## Problems When Running Many Stores on a Single Server
If you're running just one or a few Laravel websites on a single server, optimization isn't a big concern. But as we scaled up with more stores on each server, we encountered several challenges:

### Resource Waste
The resources needed for a normal Laravel website aren't particularly high. But when you have 1000 websites on a single server, resources become insufficient. Here's why:
- Each website requires at least 1 PHP-FPM pool (~100MB per FPM process)
- Each website has its own Nginx configuration (manageable)
- Each website requires a database connection (MySQL)
- Each website requires a systemd service for queue workers (horizon)
- *Each server needs a cron job for scheduled tasks (We really wanted this but couldn't—they would make CPU and RAM spike like crazy 😅)*

Even if most websites aren't very active, they still consume server resources. This was a major problem for us.

Our largest server has specs:
- **OS**: Ubuntu 22.04.5 LTS x86_64
- **Kernel**: 5.15.0-122-generic
- **Resolution**: 1024x768
- **Terminal**: /dev/pts/2
- **CPU**: Intel Xeon E5-2650 v2 (32 cores) @ 3.400GHz
- **Memory**: 2439MiB / 64320MiB

![server state before](/images/lunar-server-before.png)

So you can see, we have 32 cores and 64GB of RAM, but could only handle about 280 websites on this server. **962 tasks, wow** 😂

**What Did We Do to Solve This Problem?**

I have to say, we tried our best to keep the stores running normally. We relied heavily on caching. First, we used [laravel-responsecache](https://github.com/spatie/laravel-responsecache) from Spatie, but requests still touched the PHP-FPM process. So we switched to [laravel-pagecache](https://github.com/JosephSilber/page-cache) to serve HTML content directly from Nginx. This really helped reduce server load.

Honestly, I don't like using caching because it's hard to debug and sometimes doesn't work as expected. But we had to use it to keep the server running. The challenge isn't just the caching itself—it's keeping the cache up to date, which is really difficult. 🤣

### Slow Development
You read that right—even with CI/CD, our deployment process was incredibly slow. We had to wait over an hour to deploy every website on a server. That's painfully slow, right? 🫠 Our deployment scripts were simple:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force
pnpm install && pnpm run build
php artisan optimize
php artisan horizon:terminate
...
```

Because the server lacked free resources, the build process became very slow.

*If someone spammed composer stats for downloading packages, that was probably me 😂.*

### SSL Problems
We used certbot to automatically renew SSL certificates, but sometimes it didn't work as expected, requiring manual renewal. This was a real pain—even SSHing into the server was difficult, and we encountered many issues. I really didn't want to spend all day debugging certbot anymore. Issues like [this one](https://github.com/certbot/certbot/issues/8735) were common.

In our case, certbot somehow took ownership of the `nginx` process, forcing us to kill nginx each time we renewed certificates. Really weird, and we had to deal with it constantly.

## We Decided to Refactor Everything
Rewrite it in Rust (just kidding 😂). We'll stay with Laravel for sure.

Our new tech stack:
- Caddy as web server
- PHP-FPM as PHP processor (We use PHP 8.2 until now)
- SQLite

### Switch from Single Store to Multi-Tenant
First, we developed a multi-tenant website. Now each server deploys only 1 website that handles all requests for other sites. This was a major change for us, but necessary.
This helps us avoid unnecessary resources for running individual websites (horizon, FPM, cron, etc.).

We reimplemented our stores as multi-tenant using [Tenancy for Laravel](https://github.com/archtechx/tenancy). It's an excellent package that's easy to customize.

![pull request version 2.x](/images/lunar-loc-change.png)

**Beautiful Dashboard for Managing Stores**

The result is fantastic—now we have a beautiful dashboard for managing all stores. We can easily create new stores and manage them efficiently. The dashboard is built with [Filament](https://filamentphp.com/), which works great for us.

![manage-stores](/images/lunar-manage-stores.png)

### Switch Database from MySQL to SQLite
We use SQLite for storing data for each store. Since most of our stores have only a few hundred products, SQLite is sufficient. We can easily back up data by copying the file. Moving away from MySQL saves significant server resources that we can allocate to PHP-FPM.

To migrate from MySQL to SQLite, we use the [mysql2sqlite](https://github.com/mysql2sqlite/mysql2sqlite) script.

### Switch Web Server from Nginx to Caddy
I know Nginx has better performance than Caddy, but Caddy is much easier to use and configure. Since our traffic isn't like 10,000 requests per second, Caddy is sufficient. Plus, Caddy has the killer feature we love: [On-Demand TLS](https://caddyserver.com/on-demand-tls).

It's 2025 and SSL should not be a nightmare to maintain.

Our Caddyfile is simple: (sensitive information removed)
```caddy
{
    on_demand_tls {
        ask https://multi-tenant-store.test/on-demand-tls
    }
}

multi-tenant-store.test {
    root * /home/deploy/store/public
    encode zstd gzip
    php_fastcgi unix//run/php/php8.2-fpm.sock
    file_server
}

https:// {
    tls {
        on_demand
    }
    root * /home/deploy/store/public
    encode zstd gzip
    php_fastcgi unix//run/php/php8.2-fpm.sock
    file_server
}
```

**Migration Process**
Thankfully, the migration process was smooth. We used Ansible to migrate servers to the new version (I have no idea what Kubernetes is 😂). We don't use Docker either.

**The Result**
![after migrate](/images/lunar-after.png)

Task count reduced to 69 🙂. We disabled all Horizon processes, MySQL processes, and extra PHP-FPM processes. Now we can run scheduled tasks without worrying about resource overload. We also removed the page-cache package since we don't need it anymore. We can run stores smoothly without caching, which simplifies maintenance and debugging.

### Improved Deployment Process
Now we only deploy 1 website per server, making the deployment process lightning-fast—we can create new stores in the blink of an eye. We can focus on developing features, delivering fixes, and improving stores without worrying about slow deployments.

### Ongoing Improvements
Although we have already achieved significant resource savings and streamlined our deployment process, there are still areas we plan to improve:
- Monitoring: We're exploring tools like Prometheus or Grafana to aggregate important metrics across all stores. This will let us see exactly where any bottleneck might appear.
- Scaling Strategy: If traffic spikes, we’ll consider page cache. We won't use cloud solution or auto sclaling, that will make us broke 😂.

By focusing on these areas, we hope to keep our multi-store environment running smoothly and cost-effectively while providing the best experience for our users.

I think PHP and Laravel are still excellent for building websites, even for large numbers of sites. We just need to optimize the server and code to run everything smoothly.