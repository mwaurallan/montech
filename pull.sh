#!/usr/bin/env bash
php artisan down
git pull origin master
php artisan up
echo 'Deploy finished.'