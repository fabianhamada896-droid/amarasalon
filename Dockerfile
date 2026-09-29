FROM php:8.3-apache

# Install dependencies yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    uncurl \
    git

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy semua file project ke container
COPY . /var/www/html

# Atur DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/(!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install vendor dependencies lewat composer
RUN composer install --no-dev --optimize-autoloader

# Berikan izin akses folder storage dan bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache