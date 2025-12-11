#!/bin/bash
php artisan migrate --force
php artisan db:seed --force
exec supervisord