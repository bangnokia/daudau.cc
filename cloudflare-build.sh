#!/usr/bin/env bash

## download the binary
curl -sL https://dl.static-php.dev/static-php-cli/common/php-8.3.4-cli-linux-x86_64.tar.gz | tar xz
curl -sL https://raw.githubusercontent.com/bangnokia/lina/main/builds/lina

ls -la
##
./php lina build