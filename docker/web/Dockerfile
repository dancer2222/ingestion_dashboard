FROM richarvey/nginx-php-fpm

RUN apk add --update \
    autoconf \
    file \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c \
    zlib-dev \
    libmemcached-dev \
    cyrus-sasl-dev

RUN pecl install xdebug-2.6.0 memcached-3.0.4 \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete

RUN apk del --no-cache zlib-dev cyrus-sasl-dev \
    # Clear
    && rm -rf /tmp/* /var/cache/apk/*

# Install php extenstions
RUN docker-php-ext-install bcmath

# Install composer
RUN curl https://getcomposer.org/installer | php -- \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer

RUN composer global require hirak/prestissimo;

# Add user
RUN adduser -D -u 1000 ida

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ /var/www/html/dashboard

ADD ./run.sh /dashboard-run.sh
RUN chmod 777 /dashboard-run.sh

RUN if [ ! -d /logs ]; then mkdir /logs ; fi
RUN if [ ! -f /logs/ida.log ]; then touch /logs/ida.log && chmod 777 /logs/ida.log ; fi

ADD ./nginx.conf /etc/nginx/sites-enabled/default.conf

EXPOSE 7771

WORKDIR /var/www/html/dashboard

COPY ./supervisor-ida.conf /etc/supervisor/conf.d/

VOLUME ["/var/www/html/dashboard"]

CMD ["/dashboard-run.sh"]