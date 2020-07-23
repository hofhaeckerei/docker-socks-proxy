FROM php:cli-alpine
WORKDIR /app/

RUN apk update
RUN docker-php-ext-install sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./app/composer.json /app/composer.json
COPY ./app/index.php /app/index.php
COPY ./app/src /app/src

RUN cd /app \
	&& composer install

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 1080

ENV APP_PROXY="listen=127.0.0.1:1080"

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "/app/index.php"]

