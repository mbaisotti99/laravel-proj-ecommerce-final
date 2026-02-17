# Usiamo l'immagine ufficiale PHP con Apache (molto più stabile per Laravel)
FROM php:8.2-apache

# 1. Installiamo le dipendenze di sistema minime
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    zip \
    unzip \
    git \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Installiamo l'estensione MongoDB e quelle necessarie per Laravel
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Installiamo Composer prelevandolo dall'immagine ufficiale
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Installiamo Node.js (fondamentale per Vite/Build assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 5. Configuriamo Apache per puntare alla cartella /public di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

# 6. Copiamo il progetto nella cartella di lavoro
WORKDIR /var/www/html
COPY . .

# 7. Installiamo le dipendenze (PHP e JS)
# Usiamo --ignore-platform-reqs per sicurezza durante la build
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs
RUN npm install && npm run build

# 8. Settiamo i permessi corretti per l'utente Apache (www-data)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 9. Avvio: migrazioni e Apache in primo piano
CMD php artisan migrate --force && apache2-foreground