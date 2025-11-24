FROM php:8.2

# Update and install required dependencies, including sockets
RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git libonig-dev libzip-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) gd zip pdo_mysql pdo_pgsql sockets

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /app

# Copy project files
COPY . /app

# Rename .env.prod to .env
RUN mv .env.example .env

# Install PHP dependencies with Composer
RUN composer install --ignore-platform-req=*

# Set proper permissions for storage & bootstrap/cache
#RUN chmod -R 777 storage bootstrap/cache
RUN chmod -R 777 storage

# # Cache Laravel config to improve performance
#RUN php artisan config:cache

# Expose port 8080
EXPOSE 8000

# Start Laravel's built-in server
RUN apt-get install -y npm
RUN npm install --save-dev vite
RUN npm run build

CMD ["php", "artisan", "storage:link"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
#CMD ["php", "artisan", "migrate"]
#CMD ["php", "artisan", "db:seed"]
#CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=7111

