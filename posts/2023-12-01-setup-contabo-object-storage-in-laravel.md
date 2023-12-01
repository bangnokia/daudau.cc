---
title: Setup Contabo Object Storage s3 compatible in Laravel application
tags:
    - laravel
    - contabo
---

## Introduction
I think mostly people gonna use s3, but the aws pricing is not feel comfortable for me, so I found [contabo object storage](https://contabo.com/en/object-storage/), it's **s3 compatible** and the pricing is very cheap, so i decided to use it for my Laravel application. At the time of writing, the pricing is $2.99 per month for 250GB.
![contabo object storage pricing comparison](/images/contabo-object-storage-price-compare.png)

## Setup in Contabo
### Create bucket and get credentials
First you need to create a bucket, you can do it in the [contabo object storage panel](https://my.contabo.com/object_storage)

Also, make your bucket public, so you can access it from your application.
![contabo public bucket](/images/contabo-public-bucket.png)

Afterward, visit `Account -> Security & Access`, you will get the credentials like this:
![cotabo object storage credentials](/images/contabo-bucket-credentials.png)



## Setup in Laravel
### Install package in Laravel
First, you need to install the package:
```bash
composer require league/flysystem-path-prefixing "^3.0"
```

In the `config/filesystems.php`, modify the following code if you want, but I will keep this as default:
```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],
```

### Config our `.env` file using Contabo credentials
Please note that `AWS_USE_PATH_STYLE_ENDPOINT=true` must be true, otherwise it will not work.

```dotenv
AWS_ACCESS_KEY_ID=9ef6e69598c547336aa1d4004b2267ad
AWS_SECRET_ACCESS_KEY=4ebf11e65e469b3a7b91e87cc169b27c
AWS_DEFAULT_REGION=usc1
AWS_BUCKET=test
AWS_ENDPOINT=https://usc1.contabostorage.com # without the bucket name here, we'll use path style
AWS_URL=https://usc1.contabostorage.com/4069dd56f17142fbbbf34e43ce1902a0:test # the public url
AWS_USE_PATH_STYLE_ENDPOINT=true
```

That's it, now you can use the `Storage` facade to upload your file to Contabo object storage. For example:
```php
Storage::disk('s3')->put('test.txt', 'Hello World');
```

## Conclusion
I think Contabo object storage is a good choice for s3 compatible storage, it's cheap and easy to use.
If you have a tight budget like me, you can try it. 🚀
