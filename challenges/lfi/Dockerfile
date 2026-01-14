FROM php:8.1-apache

# Copy application files
COPY src/ /var/www/html/
COPY flag.txt /flag.txt

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod 644 /flag.txt

EXPOSE 80
