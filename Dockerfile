FROM php:8.2-cli


RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /app


COPY . .


RUN composer install --optimize-autoloader --no-dev


RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear


EXPOSE 10000


CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
