FROM php:8.1-apache

# Copy application files
COPY src/ /var/www/html/
COPY flag.txt /flag.txt

# Create some interesting files
RUN echo "root:x:0:0:root:/root:/bin/bash" > /etc/passwd.bak \
    && echo "This is a secret config file" > /var/www/config.txt

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod 644 /flag.txt

EXPOSE 80
