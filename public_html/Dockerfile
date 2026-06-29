FROM php:8.2-fpm

# Install system dependencies + Node.js 20
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libwebp-dev libjpeg-dev libonig-dev libxml2-dev zip unzip nginx ca-certificates gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Nginx config
RUN echo 'server { \
    listen 80; \
    root /var/www/public; \
    index index.php index.html; \
    client_max_body_size 100M; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
    location ~ /\.ht { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default

EXPOSE 80

CMD service nginx start && php-fpm