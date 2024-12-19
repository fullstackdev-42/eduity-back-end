FROM php:7.3-fpm-alpine
LABEL maintainer="Curtis Hicks"

WORKDIR /var/www/html

ARG HOST_USER_ID
ARG HOST_GROUP_ID
ARG HOST_USERNAME

RUN apk update

RUN set -ex && apk --no-cache add sudo

RUN apk add inotify-tools

RUN apk add --update nodejs nodejs-npm

RUN apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev

RUN apk --no-cache add libzip-dev zip \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip

RUN apk --no-cache add libxml2-dev \
    && docker-php-ext-install xml

RUN apk --no-cache add libpng-dev \
    && docker-php-ext-install gd

# now creating user
RUN if [ -z "`getent group ${HOST_GROUP_ID}`" ]; then \
      addgroup -g ${HOST_GROUP_ID} ${HOST_USERNAME}; \
    fi && \
    if [ -z "`getent passwd ${HOST_USER_ID}`" ]; then \
      adduser -S -u ${HOST_USER_ID} -G ${HOST_USERNAME} -s /bin/sh ${HOST_USERNAME}; \
    fi

RUN echo "${HOST_USERNAME} ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Install git
RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN sed -i -e "s/user = .*/user = ${HOST_USERNAME}/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i -e "s/group = .*/group = ${HOST_USERNAME}/" /usr/local/etc/php-fpm.d/www.conf