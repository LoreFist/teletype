FROM php:8.3-fpm-alpine

RUN set -eux; \
    apk add --no-cache \
        nginx \
        supervisor \
        libpq \
        libpq-dev \
        bash \
        git \
        curl \
        icu-dev \
        oniguruma-dev \
        libxml2-dev \
        unzip \
        sudo \
        $PHPIZE_DEPS; \
    pecl install redis && docker-php-ext-enable redis; \
    docker-php-ext-install pdo pdo_pgsql intl opcache

WORKDIR /var/www/html

ARG USER=user
RUN addgroup -g 1000 -S ${USER} && adduser -S -D -H -u 1000 -G ${USER} -g ${USER} ${USER} && \
    echo "${USER} ALL=(ALL) NOPASSWD:ALL" > /etc/sudoers.d/${USER} && chmod 0440 /etc/sudoers.d/${USER}

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=composer:latest /tmp/keys* /home/${USER}/.composer/
RUN chown -R ${USER}:${USER} /home/${USER}/.composer/

COPY supervisor/supervisord.conf /etc/supervisord.conf
COPY supervisor/conf.d/ /etc/supervisor/conf.d/

COPY php-fpm/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY php-fpm/cli/10-opcache.ini $PHP_INI_DIR/conf.d/

COPY nginx/fastcgi-php.conf /etc/nginx/fastcgi-php.conf
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/conf.d/* /etc/nginx/conf.d/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

EXPOSE 80