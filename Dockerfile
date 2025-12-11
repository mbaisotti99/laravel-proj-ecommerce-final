FROM webdevops/php-nginx:8.2

WORKDIR /app

# Installa Node
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copia il progetto
COPY . /app

# Cartella storage pubblica
RUN cp -R /app/storage/app/public /app/public/storage

# Installa dipendenze PHP
RUN composer install --no-dev --optimize-autoloader

# Installa dipendenze JS e build
RUN npm install && npm run build

ENV WEB_DOCUMENT_ROOT=/app/public

# Storage link
RUN php artisan storage:link

# Permessi
RUN chown -R application:application /app/storage /app/bootstrap/cache

RUN chmod +x entrypoint.sh

EXPOSE 80

# CMD ./entrypoint.sh
CMD supervisord