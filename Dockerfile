FROM richarvey/nginx-php-fpm

RUN apk add --update \
    autoconf \
    file \
    nano \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c \
    zlib-dev \
    libmemcached-dev \
    cyrus-sasl-dev \
    && git clone --branch php7 https://github.com/php-memcached-dev/php-memcached.git /usr/src/php/ext/memcached/ \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && docker-php-source delete \
    && apk del --no-cache zlib-dev cyrus-sasl-dev \

    # Clear
    && rm -rf /tmp/* /var/cache/apk/*

# Install php extenstions
RUN docker-php-ext-install bcmath

# Install composer
RUN curl https://getcomposer.org/installer | php -- \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer

# Add user
RUN adduser -D -u 1000 ida

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./ /var/www/html/dashboard

ADD ./run.sh /dashboard-run.sh
RUN chmod 777 /dashboard-run.sh

ADD ./nginx.conf /etc/nginx/sites-enabled/default.conf

EXPOSE 7771

WORKDIR /var/www/html/dashboard
RUN composer install

VOLUME ["/var/www/html/dashboard"]

CMD ["/dashboard-run.sh"]