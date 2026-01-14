FROM php:8.1-apache

# Install dependencies untuk bot
RUN apt-get update && apt-get install -y \
    chromium \
    chromium-driver \
    python3 \
    python3-venv \
    cron \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Create virtual environment and install Python dependencies
RUN python3 -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"
RUN pip install --no-cache-dir selenium requests

# Copy application files
COPY src/ /var/www/html/
COPY bot/ /opt/bot/
COPY flag.txt /flag.txt
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod 644 /flag.txt \
    && chmod +x /opt/bot/bot.py

# Create data directory
RUN mkdir -p /var/www/html/data && chown www-data:www-data /var/www/html/data

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
