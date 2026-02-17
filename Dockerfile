FROM webdevops/php-nginx:8.2

WORKDIR /app

# 1. Installa i tool di compilazione e le dipendenze per MongoDB
RUN apt-get update && apt-get install -y \
    build-essential \
    php8.2-dev \
    php-pear \
    libssl-dev \
    pkg-config \
    unzip \
    && pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Installa Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Copia il progetto
COPY . /app

# 4. Installazione dipendenze PHP (Composer)
# Ignoriamo i check della piattaforma per evitare errori durante la build
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# 5. Installa dipendenze JS e build assets
RUN npm install && npm run build

# 6. Configurazione Laravel
RUN php artisan storage:link || true

# 7. Permessi
RUN chown -R application:application /app/storage /app/bootstrap/cache

ENV WEB_DOCUMENT_ROOT=/app/public
EXPOSE 80

# 8. Comando di avvio
CMD php artisan migrate --force && exec supervisord