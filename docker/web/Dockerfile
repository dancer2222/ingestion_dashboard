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
    cyrus-sasl-dev

RUN apk add --update nodejs

RUN pecl install xdebug-2.6.0 memcached-3.0.4 \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install bcmath \
    && docker-php-source delete

# Configure xdebug
#ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_connect_back=Off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apk del --no-cache zlib-dev cyrus-sasl-dev \
    # Clear
    && rm -rf /tmp/* /var/cache/apk/*

# Install composer
RUN curl https://getcomposer.org/installer | php -- \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer

RUN composer global require hirak/prestissimo;

# Add user
RUN adduser -D -u 1000 ida

COPY ./ /var/www/html/dashboard
COPY ./crontab /var/spool/cron/crontabs/root
COPY ./supervisor-ida.conf /etc/supervisor/conf.d/
COPY ./nginx.conf /etc/nginx/sites-enabled/default.conf
COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./run.sh /dashboard-run.sh

RUN chmod 777 /dashboard-run.sh

RUN if [ ! -d /logs ]; then mkdir /logs ; fi
RUN if [ ! -f /logs/ida.log ]; then touch /logs/ida.log && chmod 777 /logs/ida.log ; fi

EXPOSE 7771

VOLUME ["/var/www/html/dashboard"]

WORKDIR /var/www/html/dashboard

CMD ["/dashboard-run.sh"]