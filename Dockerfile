# Usiamo l'immagine ufficiale PHP con Apache (più semplice per Laravel)
FROM php:8.2-apache

# 1. Installa le dipendenze di sistema necessarie
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    zip \
    unzip \
    git \
    curl

# 2. Installa l'estensione MongoDB e le estensioni core di PHP per Laravel
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Installa Node.js (necessario per Vite/npm build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 5. Configura Apache per Laravel (imposta la DocumentRoot su /public)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

# 6. Copia il progetto
WORKDIR /var/www/html
COPY . .

# 7. Installa dipendenze PHP e JS
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs
RUN npm install && npm run build

# 8. Permessi per Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 9. Avvio: migrazioni e Apache
CMD php artisan migrate --force && apache2-foreground