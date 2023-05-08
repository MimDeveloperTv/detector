##
# cli
##
FROM git.wki.ir:5050/docker/php:8.1-cli-alpine AS cli

WORKDIR /app

COPY ./docker/prod/php-cli-entrypoint /usr/local/bin/custom-entrypoint
RUN chmod +x /usr/local/bin/custom-entrypoint
ENTRYPOINT ["custom-entrypoint"]

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-plugins --no-autoloader --prefer-dist

COPY . .
RUN composer install --optimize-autoloader --no-dev

##
# fpm_server
##
FROM git.wki.ir:5050/docker/php:8.1-fpm-alpine AS fpm_server

WORKDIR /app

COPY ./docker/prod/php-cli-entrypoint /usr/local/bin/custom-entrypoint
RUN chmod +x /usr/local/bin/custom-entrypoint
ENTRYPOINT ["custom-entrypoint"]

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-plugins --no-autoloader --prefer-dist

COPY --chown=www-data . .
RUN composer install --optimize-autoloader --no-dev

CMD ["php-fpm"]

##
# web_server
##
FROM git.wki.ir:5050/docker/nginx:alpine AS web_server

WORKDIR /app

COPY ./docker/prod/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY --chown=nginx --from=fpm_server /app .
