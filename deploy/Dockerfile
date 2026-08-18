# Duas imagens saem daqui:
#   --target app -> php-fpm com o codigo e o vendor
#   --target web -> nginx com o public/ copiado do app
#
# Build a partir da RAIZ do projeto:
#   docker build -f deploy/Dockerfile --target app -t controla-app .

# ---------------------------------------------------------------- dependencias

FROM composer:2 AS deps

WORKDIR /app

# composer.json e lock primeiro: enquanto eles nao mudam, o docker reaproveita
# esta camada e nao baixa o vendor de novo a cada deploy
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY app/ app/
COPY public/ public/
RUN composer dump-autoload --optimize --no-dev

# ------------------------------------------------------------------------ app

FROM php:8.2-fpm-alpine AS app

# gd e exigido pelo mpdf; pdo_mysql pelo illuminate/database.
# As libs -dev entram e saem no mesmo RUN para nao ficarem na imagem final.
RUN apk add --no-cache libpng libjpeg-turbo freetype \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd pdo_mysql opcache \
    && apk del .build-deps

COPY deploy/php/php.ini /usr/local/etc/php/conf.d/controla.ini

WORKDIR /var/www/html

COPY --from=deps /app/vendor/ vendor/
COPY app/ app/
COPY public/ public/
COPY database/ database/

# unico diretorio que a aplicacao escreve (Cubo\ErrorHandler + FileLogger)
RUN mkdir -p app/Controla/logs && chown -R www-data:www-data app/Controla/logs

# o config.ini NAO entra na imagem: vem por bind mount, com as senhas de verdade

# ------------------------------------------------------------------------ web

FROM nginx:1.27-alpine AS web

COPY deploy/nginx/app.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public /var/www/html/public
