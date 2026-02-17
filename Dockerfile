FROM webdevops/php-nginx:8.2

WORKDIR /app

# 1. Installazione dipendenze di sistema e estensione MongoDB
# Usiamo i pacchetti pre-compilati se possibile, oppure installiamo i tool di build
RUN apt-get update && apt-get install -y \
    php8.2-mongodb \
    libssl-dev \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Installa Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Copia il progetto
COPY . /app

# 4. Installazione dipendenze PHP (Composer)
# Nota: usiamo --ignore-platform-req=ext-mongodb se l'estensione non viene vista subito durante la build
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 5. Installa dipendenze JS e build assets (Vite/Mix)
RUN npm install && npm run build

# 6. Configurazione Laravel
RUN cp -R /app/storage/app/public /app/public/storage || true
RUN php artisan storage:link

# 7. Permessi (webdevops usa l'utente 'application')
RUN chown -R application:application /app/storage /app/bootstrap/cache

ENV WEB_DOCUMENT_ROOT=/app/public
EXPOSE 80

# 8. Comando di avvio (Rimosso migrate:fresh per evitare perdita dati al riavvio)
CMD php artisan migrate --force && exec supervisord