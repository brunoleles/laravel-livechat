FROM php:8.0.9-apache

#Update & install os deps
RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
        libpng-dev \
        libfreetype6-dev \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        zip \
        git \
    && docker-php-ext-install \
        zip pdo_mysql gd pcntl \
    && cd /usr/src/ \
    && pecl bundle \
        ds \
    && docker-php-ext-configure \
        /usr/src/ds \
    && docker-php-ext-install \
        /usr/src/ds \
    && cd /var/www/html \
    && a2enmod \
        rewrite \
        proxy \
        proxy_http \
        proxy_wstunnel

RUN  apt install -y nodejs && apt install npm -y;

# Add the user UID:1000, GID:1000, home at /app
RUN groupadd -r app -g 1000 && useradd -u 1000 -r -g app -m -d /app -s /sbin/nologin -c "App user" app && \
    chmod 755 /var/www/html

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN echo "file_uploads = On\n" \
         "memory_limit = 500M\n" \
         "upload_max_filesize = 500M\n" \
         "post_max_size = 500M\n" \
         "max_execution_time = 600\n" \
         > /usr/local/etc/php/conf.d/uploads.ini

USER app

WORKDIR /var/www/html

USER root

COPY dockers/web/default.conf /etc/apache2/sites-enabled/000-default.conf

COPY --chown=app:www-data package*.json composer.json composer.lock ./

RUN npm install --silent --production && composer install --no-dev --no-scripts;

COPY --chown=app:www-data . .

RUN echo "" \
    # chown -R app . -v \
    && npm run production \
    && composer dump-autoload \
    && php artisan optimize

ARG SERVERS="both"
ENV SERVERS ${SERVERS}

# CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
CMD ["/var/www/html/dockers/web/entrypoint.sh"]


EXPOSE 80
EXPOSE 81
