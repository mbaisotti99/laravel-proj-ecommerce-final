FROM webdevops/php-nginx:8.2

WORKDIR /app

# Installa Node
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copia il progetto
COPY . .

# Installa dipendenze PHP
RUN composer install --no-dev --optimize-autoloader

# Installa dipendenze JS e build
RUN npm install && npm run build

# Storage link
RUN php artisan storage:link

# Permessi
RUN chown -R application:application /app/storage /app/bootstrap/cache

EXPOSE 80

CMD php artisan migrate --force && supervisord