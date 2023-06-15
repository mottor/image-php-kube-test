#ARG MLOCATI_PHP_EXTENSION_INSTALLER_VERSION=1.2.44
ARG PHP_VERSION=8.1.19

#FROM mlocati/php-extension-installer:$MLOCATI_PHP_EXTENSION_INSTALLER_VERSION AS php-extension-installer
#FROM mottor1/cleanimage:1.0 AS cleaner
FROM php:$PHP_VERSION-fpm-bullseye

#COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
#COPY --from=cleaner /usr/local/bin/cleanimage /usr/local/bin/cleanimage
#
#RUN install-php-extensions pdo_mysql \
#    && cleanimage \
#    && php -m

RUN export DEBIAN_FRONTEND=noninteractive \
    && apt-get update \
    && apt-get install -y libcurl4-openssl-dev

RUN docker-php-ext-install curl pdo pdo_mysql

RUN mkdir -p /var/www/html

COPY ./src /var/www/html
