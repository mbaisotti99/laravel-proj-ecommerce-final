#!/bin/bash
php artisan migrate --force
php artisan db:seed
exec supervisord