FROM php:7-fpm

RUN docker-php-ext-install mysqli pdo_mysql bcmath
RUN apt-get update && apt-get install -y libz-dev libmemcached-dev curl \
	nginx

RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
           && mkdir -p /usr/src/php/ext/memcached \
           && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
           && docker-php-ext-configure memcached \
           && docker-php-ext-install memcached \
           && rm /tmp/memcached.tar.gz \
    && docker-php-ext-install zip \
	# Install composer
	&& curl https://getcomposer.org/installer | php -- \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer \
    && adduser ida

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ /code/dashboard

COPY ./run.sh /dashboard-run.sh
RUN chmod 777 /dashboard-run.sh

COPY ./dashboard.conf /etc/nginx/sites-enabled/default.conf

EXPOSE 7771

WORKDIR /code/dashboard
RUN composer install --no-dev

VOLUME ["/code/dashboard"]

CMD ["/dashboard-run.sh"]