FROM alpine:3.16

### Install packages ###
RUN apk update && \
    apk add --no-cache \
    openssl tzdata \
    apache2 apache2-ssl \
    unzip \
    curl \
    php81 \
    php81-apache2 \
    php81-phpdbg \
    php81-session \
    php81-mbstring \
    php81-gd \
    php81-mysqli \
    php81-pdo \
    php81-pdo_sqlite \
    php81-curl \
    php81-json \
    php81-bcmath \
    php81-ctype \
    php81-fileinfo \
    php81-openssl \
    php81-tokenizer \
    php81-xml \
    php81-pdo_mysql \
    php81-phar \
    php81-intl \
    php81-dom \
    php81-xmlwriter \
    php81-simplexml \
    php81-zip \
    php81-exif \
    php81-pecl-imagick \
    php81-iconv

RUN ln -s /usr/bin/php81 /usr/bin/php

### Set Timezone ###
RUN cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

### Set SSL server certificate ###
WORKDIR /etc/ssl/certs
RUN openssl genrsa 2048 > ca.key && \
    openssl req -new -key ca.key -subj "/C=JP/ST=Tokyo/L=Shibuya/O=un-T" > ca.csr && \
    openssl x509 -days 3650 -req -signkey ca.key < ca.csr > ca.crt

### Add config files ###
COPY ./conf/php.ini /etc/php7/conf.d/my.ini
COPY ./conf/httpd.conf /etc/apache2/conf.d/vhost.conf

## Mailhog
WORKDIR /tmp
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail

### composer ###
COPY ./conf/composer.sh /tmp/composer.sh
RUN chmod +x /tmp/composer.sh && \
    /tmp/composer.sh && \
    mv composer.phar /usr/local/bin/composer && \
    rm /tmp/composer.sh

WORKDIR /var/www/src/
CMD ["sh", "-c", "/usr/sbin/httpd; tail -f /dev/null;"]
# CMD ["sh", "-c", "postfix start; /usr/sbin/httpd; tail -f /dev/null;"]
