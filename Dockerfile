FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . /var/www/html

# Set Apache DocumentRoot directly to Laravel public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache Rewrite Module & AllowOverride
RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/html\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Server name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Composer install dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Permissions for storage, bootstrap cache, and database
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/database \
    && chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/database \
    && chmod 664 /var/www/html/database/database.sqlite

# Custom Apache startup script copy
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["/usr/local/bin/docker-entrypoint.sh"]