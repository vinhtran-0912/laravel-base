FROM nginx:latest

MAINTAINER Nguyen Khac Duy Ngoc <nguyenkhacduyngoc@gmail.com>

ENV TERM xterm

ADD ./.docker/nginx/config/nginx.conf /etc/nginx/nginx.conf
ADD ./.docker/nginx/config/conf.d/default.conf /etc/nginx/conf.d/default.conf
ADD ./.docker/nginx/config/conf.d/upstream.conf /etc/nginx/conf.d/upstream.conf
ADD ./.docker/nginx/config/modules/daemon.conf /etc/nginx/modules/daemon.conf

RUN usermod -u 1000 www-data
RUN mkdir -p /var/www/app/public/ \
    && touch /var/www/app/public/index.php

CMD ["nginx"]

EXPOSE 80 443
