FROM alpine/git as wait-src
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.8.0/wait /wait

# TODO: Wait for https://github.com/swoole/swoole-src/issues/4545 and replase version on latest
FROM phpswoole/swoole:4.8.5-php8.1-alpine

ARG DEBUG='false'
ARG RUN_DEPS='postgresql-libs'
ARG BUILD_DEPS='postgresql-dev'
ARG PHP_EXTENSIONS='pdo_pgsql pcntl'

# Validate args
RUN if [[ $DEBUG != 'true' && $DEBUG != 'false' ]]; then echo 'DEBUG argument must be `true` or `false`!'; exit 1; fi

# Preparing system
RUN echo 'UTC' > /etc/timezone
COPY --from=wait-src /wait /.
RUN chmod +x /wait
RUN apk update \
    && apk add --no-cache --virtual .build-deps $BUILD_DEPS \
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*
RUN apk add --no-cache --virtual .run-deps $RUN_DEPS
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Preparing code base
COPY composer.json .
COPY composer.lock .
RUN composer install --no-interaction --no-progress --no-autoloader --no-cache \
    $(if [[ $DEBUG == 'true' ]]; then echo '--dev'; else echo '--no-dev'; fi)
COPY . .
RUN composer dump-autoload
RUN if [[ $DEBUG == 'true' ]]; then \
        apk add nodejs; \
        apk add npm; \
        npm install --save-dev; \
    fi

CMD /wait && php artisan octane:start --host=0.0.0.0
