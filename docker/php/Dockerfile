FROM php:7.4-fpm-alpine

RUN set -eux && \
    apk update && \
    apk add --no-cache patch make bash && \
    apk del && \
    rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer opcache pdo_pgsql pgsql intl pcov pcntl && \
    ln -s composer /usr/local/bin/c

COPY --link docker/php/php.ini $PHP_INI_DIR/conf.d/
COPY --link docker/php/fpm.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN addgroup -g 1000 phpgroup && \
    adduser -G phpgroup -u 1000 -D phpuser

RUN mkdir /var/run/php && \
    chown -R phpuser:phpgroup /var/run/php && \
    chown -R phpuser:phpgroup /var/www/html

USER phpuser