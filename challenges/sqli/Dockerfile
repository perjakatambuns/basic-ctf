FROM php:8.1-apache

# Install SQLite
RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application files
COPY src/ /var/www/html/
COPY init.php /var/www/init.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Initialize database
RUN php /var/www/init.php

EXPOSE 80
