---
title: How we handle 1000 Laravel websites on a single server
layout: post
tags:
    - laravel
    - caddy
---

From the early days, we have been using Laravel to build websites for selling products online. To quickly go online to sell stuff, we use Laravel as a storefront for rapid development.

We use [lunarphp](https://lunarphp.io/) to develop ecommerce functionality. It is a Laravel package that provides a lot of features for ecommerce websites.

For each kind of product, we deploy a new website. So we have lots of stores running on a few servers.

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

To create a new store, we just go to Jenkins and run the Ansible playbook. Everything is automated so we can focus on developing the store, and that's quite simple and easy.

## Problems When Running Many Stores on a Single Server
If you are just running one or a few Laravel websites on a single server, optimizing the server is not really a big deal. But as time goes by, we have more and more stores running on a single server, and we have to face some problems:

### Waste of Server Resources
The resources for running a normal Laravel functional website are not really high. But when you have 1000 websites running on a single server, the server resources are not enough. Let me explain:
- Each website requires at least 1 PHP-FPM pool (We use about 100MB per FPM process)
- Each website has its own Nginx configuration (not a big deal)
- Each website requires a database connection (MySQL)
- Each website requires a systemd service for running queue workers (horizon)
- *Each server requires a cron job for running scheduled tasks (We really want this but we can't, they will make the CPU and RAM spike crazy 😅)*

So even if most of the websites are not really active, they still consume the server resources. And that's really a big problem for us.

Our largest server has specs:
- **OS**: Ubuntu 22.04.5 LTS x86_64
- **Kernel**: 5.15.0-122-generic
- **Resolution**: 1024x768
- **Terminal**: /dev/pts/2
- **CPU**: Intel Xeon E5-2650 v2 (32 cores) @ 3.400GHz
- **Memory**: 2439MiB / 64320MiB

![server state before](/images/lunar-server-before.png)

So you can see, we have 32 cores, 64GB of RAM, but we can only handle about 280 websites on this server. **962 tasks, wow** 😂

### What Did We Do to Solve This Problem?
I have to say, we tried our best and could run the store normally at that time. We had to use caching to run the store smoothly. First, we used [laravel-responsecache](https://github.com/spatie/laravel-responsecache) from Spatie, but the request still touched the PHP-FPM process, so we had to use [laravel-pagecache](https://github.com/JosephSilber/page-cache) to serve the HTML content directly from Nginx. That really helped us to reduce the server load.

From my side, I really don't like to use caching, because it's hard to debug and sometimes it doesn't work as expected. But we had to use it to keep the server running. The hard thing is not only the caching, the hard thing is we have to keep the cache up to date, and that's really hard to do. 🤣

### Slow Development
You did not read wrong, even though we have CI/CD, the deployment process is really slow. We have to wait for more than 1 hour to deploy every website on a server. That's really slow, right? 🫠 Our deployment scripts are just simple like

```bash
git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force
pnpm install && pnpm run build
php artisan optimize
php artisan horizon:terminate
...
```

Because the server doesn't have much free resources, the build process becomes very slow.

*If someone spams composer stats for downloading packages, that could be me 😂.*

### SSL Problems
We use certbot to automatically renew the SSL certificate, but sometimes it doesn't work as expected. And we have to manually renew the certificate. That's really a pain, even SSHing into the server, it's still hard to do and we got lots of trouble. I really don't want to spend all day debugging and dealing with certbot anymore. Something like this [issue-8735](https://github.com/certbot/certbot/issues/8735).

In our case, somehow certbot takes ownership of the `nginx` process and we have to kill nginx each time we renew the certificate. That's really weird and we have to deal with it.

## We Decided to Refactor Everything
Rewrite it in Rust (just kidding 😂). We'll stay with Laravel for sure.

Our new tech stack:
- Caddy as web server
- PHP-FPM as PHP processor (We use PHP 8.2 until now)
- SQLite

### Change from Single Store to Multi-Tenant
First of all, we have to develop a multi-tenant website. So on each server, we only deploy 1 website, and that website will handle all the requests for other websites. That's really a big change for us, but we have to do it.
That will help us avoid all unnecessary resources for running a website. (horizon, FPM, cron, ...)

We reimplemented our stores to be multi-tenant using the package [Tenancy for Laravel](https://github.com/archtechx/tenancy). That's really a great package, and it's really easy to customize.

![pull request version 2.x](/images/lunar-loc-change.png)

**Beautiful Dashboard for Managing Stores**

And the result is so great, now we have a beautiful dashboard for managing all the stores. We can easily create new stores, and manage the stores easily. The dashboard is built with [Filament](https://filamentphp.com/), and it's really great for us.

![manage-stores](/images/lunar-manage-stores.png)

### Change Database from MySQL to SQLite
We use SQLite for storing data for each store. Because mostly our stores only have a few hundred products, SQLite is really enough for us. And we can easily back up the data by just copying the file. By moving away from MySQL, we can save a lot of resources for running the server. So just spend it on PHP-FPM.

To migrate from MySQL to SQLite, we use the [mysql2sqlite](https://github.com/mysql2sqlite/mysql2sqlite) script.

### Change Web Server from Nginx to Caddy
I know that Nginx has better performance than Caddy, but Caddy is really easy to use and configure. Btw our traffic is not really like 10000 requests per second, so Caddy is really enough for us. Also, Caddy has the killer feature that we really love, that's [On-Demand TLS](https://caddyserver.com/on-demand-tls).

It's 2025 and SSL should not be a nightmare to maintain.

Our Caddyfile is really simple like this: (I have to remove some sensitive information)
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
Thankfully, the migration process is really smooth. We use Ansible to migrate the server to the new version (I have no idea what Kubernetes is 😂). We do not use Docker either.

**The Result**
![after migrate](/images/lunar-after.png)

Tasks count reduced to 69 🙂. We just disabled all Horizon processes, MySQL processes, PHP-FPM processes. Now we can run scheduled tasks without worrying about resource overload. We also removed the page-cache package, because we don't need it anymore. We can run the store smoothly without caching, which simplifies maintenance and debugging.

### Improve Deployment Process
Now we only deploy 1 website on a server, so the deployment process is really fast, even create a new stor in blink of an eye. We can focus on developing features, delivering fixes, and improving the store without worrying about the deployment process.

### Ongoing Improvements
Although we have already achieved significant resource savings and streamlined our deployment process, there are still areas we plan to improve:
- Monitoring: We're exploring tools like Prometheus or Grafana to aggregate important metrics across all stores. This will let us see exactly where any bottleneck might appear.
- Scaling Strategy: If traffic spikes, we’ll consider page cache. We won't use cloud solution or auto sclaling, that will make us broke 😂.

By focusing on these areas, we hope to keep our multi-store environment running smoothly and cost-effectively, while still providing the best experience for our users.

So I think PHP and Laravel are still great for building websites, even for a large number of websites. We just need to optimize the server and the code to make it run smoothly.