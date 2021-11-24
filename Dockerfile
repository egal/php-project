FROM alpine/git:v2.32.0 as wait
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.8.0/wait /wait


FROM php:8.0.13-alpine

ARG DEBUG='false'
ARG USER='nonroot'
ARG UID=1000
ARG RUN_DEPS='postgresql-libs'
ARG BUILD_DEPS='postgresql-dev'
ARG PHP_EXTENSIONS='sockets pcntl pdo_pgsql'

# Validate args
RUN if [ $DEBUG != 'true' && $DEBUG != 'false' ]; then echo 'DEBUG argument must be `true` or `false`!'; exit 1; fi

# Preparing system
RUN echo "UTC" > /etc/timezone
RUN adduser -S $user -u $uid -H -G root
COPY --from=wait /wait /.
RUN chmod +x /wait
RUN apk add --no-cache --virtual .build-deps $BUILD_DEPS \
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    && apk del .build-deps
RUN apk add --no-cache --virtual .run-deps $RUN_DEPS
COPY --from=composer /usr/bin/composer /usr/bin/composer
USER $user
WORKDIR /app

# Preparing code base
COPY --chown=$user composer.json .
COPY --chown=$user composer.lock .
RUN composer install --no-interaction --no-progress --no-autoloader --no-cache \
    $(if [ $DEBUG == 'true' ]; then echo '--dev'; else echo '--no-dev'; fi)
COPY . .
RUN composer dump-autoload
COPY --chown=$user . .

# Cleanup before run
USER 'root'
RUN if [ $DEBUG == 'false' ]; then rm /usr/bin/composer; fi
USER $user

CMD /wait && php artisan egal:run
