FROM php:8.2-cli

WORKDIR /app

# Install PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip git curl libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip mbstring bcmath \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Generate app key if not set, run migrations
RUN php artisan config:clear && php artisan route:clear

# Railway sets PORT env var
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}