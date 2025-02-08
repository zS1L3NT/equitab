FROM bitnami/laravel:11.6.0

WORKDIR /app

RUN apt-get update
RUN apt-get install -y php-pgsql
RUN apt-get clean

RUN sed -ri -e 's!;extension=pdo_pgsql!extension=pdo_pgsql!' /opt/bitnami/php/etc/php.ini
RUN sed -ri -e 's!;extension=pgsql!extension=pgsql!' /opt/bitnami/php/etc/php.ini

RUN sed -ri -e 's!;zend_extension = xdebug!zend_extension = xdebug!' /opt/bitnami/php/etc/php.ini
RUN sed -ri -e 's!;xdebug.mode = debug!xdebug.mode = debug\nxdebug.start_with_request=yes!' /opt/bitnami/php/etc/php.ini
RUN sed -ri -e 's!;xdebug.client_host = 127.0.0.1!xdebug.client_host = host.docker.internal!' /opt/bitnami/php/etc/php.ini
RUN sed -ri -e 's!;xdebug.client_port = 9000!xdebug.client_port = 9000!' /opt/bitnami/php/etc/php.ini

COPY . .

EXPOSE 8000
CMD [ "/opt/bitnami/scripts/laravel/run.sh" ]