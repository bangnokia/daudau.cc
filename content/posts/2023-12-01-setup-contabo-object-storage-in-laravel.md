---
title: Set up Contabo Object Storage (S3 compatible) in a Laravel application
tags:
    - laravel
    - contabo
    - storage
layout: post
---

## Introduction
I think most people are gonna use S3, but AWS pricing doesn't feel right for me, so I found [Contabo Object Storage](https://contabo.com/en/object-storage/). It's **S3 compatible** and the pricing is very cheap, so I decided to use it for my Laravel application. At the time of writing, the pricing is $2.99 per month for 250GB.
![contabo object storage pricing comparison](/images/contabo-object-storage-price-compare.png)

## Setup in Contabo
### Create bucket and get credentials
First, you need to create a bucket. You can do it in the [Contabo Object Storage panel](https://my.contabo.com/object_storage).

Also, make your bucket public, so you can access it from your application.
![contabo public bucket](/images/contabo-public-bucket.png)

Afterward, visit `Account -> Security & Access`; you will get the credentials like this:
![contabo object storage credentials](/images/contabo-bucket-credentials.png)



## Setup in Laravel
### Install the package in Laravel
First, you need to install the package:
```bash
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
```

In `config/filesystems.php`, modify the following code if you want, but I will keep it as the default:
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

### Configure the `.env` file using Contabo credentials
Please note that `AWS_USE_PATH_STYLE_ENDPOINT` must be set to `true`; otherwise, it will not work.

```dotenv
AWS_ACCESS_KEY_ID=9ef6e69598c547336aa1d4004b2267ad
AWS_SECRET_ACCESS_KEY=4ebf11e65e469b3a7b91e87cc169b27c
AWS_DEFAULT_REGION=usc1
AWS_BUCKET=test
AWS_ENDPOINT=https://usc1.contabostorage.com # without the bucket name here, we'll use path style
AWS_URL=https://usc1.contabostorage.com/4069dd56f17142fbbbf34e43ce1902a0:test # the public url
AWS_USE_PATH_STYLE_ENDPOINT=true
```

That's it. Now you can use the `Storage` facade to upload your files to Contabo Object Storage. For example:
```php
Storage::disk('s3')->put('test.txt', 'Hello World');
```

## Conclusion
I think Contabo Object Storage is a good choice for S3-compatible storage. It's cheap and easy to use.
If you have a tight budget like me, you can try it. 🚀
