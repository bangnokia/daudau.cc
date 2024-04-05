#!/usr/bin/env bash

## download the PHP binary
curl -sL https://dl.static-php.dev/static-php-cli/common/php-8.3.4-cli-linux-x86_64.tar.gz | tar xz

## download the lina phar
curl -o lina https://raw.githubusercontent.com/bangnokia/lina/releases/latest/download/lina.phar

./php lina build