# =====================================
# Stage 1 - Install PHP dependencies
# =====================================
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-interaction \
    --no-progress

COPY . .

RUN composer dump-autoload --optimize


# =====================================
# Stage 2 - Build frontend assets
# =====================================
FROM node:20 AS node

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# =====================================
# Stage 3 - Production Image
# =====================================
FROM php:8.2-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    zip \
    curl \
    ca-certificates \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

# Copy application
COPY . .

# Copy vendor from composer stage
COPY --from=composer /app/vendor ./vendor

# Copy frontend build
COPY --from=node /app/public/build ./public/build

# Permissions
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    public/uploads/imports && \
    chown -R www-data:www-data storage bootstrap/cache public/uploads && \
    chmod -R 775 storage bootstrap/cache public/uploads

# Nginx configuration
RUN rm -f /etc/nginx/sites-enabled/default && \
    printf "server {\n\
    listen 80;\n\
    server_name _;\n\
    root /var/www/public;\n\
    index index.php index.html;\n\
\n\
    client_max_body_size 100M;\n\
\n\
    location / {\n\
        try_files \$uri \$uri/ /index.php?\$query_string;\n\
    }\n\
\n\
    location ~ \.php$ {\n\
        include fastcgi_params;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;\n\
    }\n\
\n\
    location ~ /\.ht {\n\
        deny all;\n\
    }\n\
}\n" > /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]