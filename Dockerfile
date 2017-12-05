FROM php:7-fpm

RUN docker-php-ext-install mysqli pdo_mysql
RUN apt-get update && apt-get install -y libz-dev libmemcached-dev curl \
	nginx

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
           && mkdir -p /usr/src/php/ext/memcached \
           && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
           && docker-php-ext-configure memcached \
           && docker-php-ext-install memcached \
           && rm /tmp/memcached.tar.gz \
    && docker-php-ext-install zip \
	# Install composer
	&& curl https://getcomposer.org/installer | php -- \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ /code/dashboard

COPY ./run.sh /dashboard-run.sh
RUN chmod 777 /dashboard-run.sh

COPY ./dashboard.conf /etc/nginx/sites-enabled/default.conf

EXPOSE 7771

VOLUME ["/code/dashboard"]

CMD ["/dashboard-run.sh"]