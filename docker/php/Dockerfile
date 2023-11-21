FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
    gcc make autoconf libc-dev pkg-config

RUN pecl install channel://pecl.php.net/xdebug-3.3.0alpha3
RUN docker-php-ext-enable xdebug

RUN echo "zend_extension = xdebug.so" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.idekey = phpstorm" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_port = 9001" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
