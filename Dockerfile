FROM php:8-fpm-alpine
LABEL Description="Lightweight container with Nginx 1.14 & PHP-FPM 8.2 based on Alpine Linux."

# Install packages
RUN apk --no-cache add php8 php8-pdo php8-fpm php8-pdo_mysql php8-json php8-openssl php8-curl \
    php8-zlib php8-xml php8-phar php8-intl php8-dom php8-xmlreader php8-ctype php8-iconv php8-simplexml php8-zip\
    php8-mbstring php8-gd php8-xml php8-xmlwriter php8-tokenizer php8-session nginx supervisor curl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Configure nginx
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY nginx/fpm-pool.conf /etc/php8/php-fpm.d/zzz_custom.conf
COPY nginx/php.ini /etc/php8/conf.d/zzz_custom.ini

# Configure supervisord
COPY nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Environment Variabless
ENV APP_LOG errorlog
# Add application
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY . /var/www/html
RUN cd /var/www/html && composer install

run chmod -R 777 storage/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
