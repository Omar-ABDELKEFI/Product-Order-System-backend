# Use an official PHP runtime as a parent image
FROM php:7.4

# Set the working directory to /app
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the composer.json and composer.lock
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the application code
COPY . .

# Generate optimized autoload files and cache
RUN composer dump-autoload --optimize

# Expose port 8000 (or any other port you want to use)
EXPOSE 8000

# Start Laravel using php artisan serve with custom host and port
CMD php artisan serve --host=0.0.0.0 --port=8000
