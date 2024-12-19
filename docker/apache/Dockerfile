FROM httpd:2.4-alpine
LABEL maintainer="Curtis Hicks"

WORKDIR /var/www/html

ARG HOST_USER_ID
ARG HOST_GROUP_ID
ARG HOST_USERNAME

ENV APACHE_RUN_USER ${HOST_USERNAME}
ENV APACHE_RUN_GROUP ${HOST_USERNAME}

RUN set -ex && apk --no-cache add sudo


RUN mkdir -p /usr/local/apache2/conf/
COPY httpd.conf /usr/local/apache2/conf/httpd.conf
COPY vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf

# now creating user
RUN if [ -z "`getent group ${HOST_GROUP_ID}`" ]; then \
      addgroup -g ${HOST_GROUP_ID} ${HOST_USERNAME}; \
    fi && \
    if [ -z "`getent passwd ${HOST_USER_ID}`" ]; then \
      adduser -S -u ${HOST_USER_ID} -G ${HOST_USERNAME} -s /bin/sh ${HOST_USERNAME}; \
    fi

RUN echo "${HOST_USERNAME} ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
