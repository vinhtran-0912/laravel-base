FROM php:7.3-fpm

MAINTAINER Nguyen Khac Duy Ngoc <nguyenkhacduyngoc@gmail.com>

# The environment variable TERM contains a identifier for the text window’s capabilities.
# When producing text with embedded color directives, msgcat looks at the TERM variable. Text windows today typically support at least 8 colors. Often, however, the text window supports 16 or more colors, even though the TERM variable is set to a identifier denoting only 8 supported colors. It can be worth setting the TERM variable to a different value in these cases:
# - xterm is in most cases built with support for 16 colors. It can also be built with support for 88 or 256 colors (but not both). You can try to set TERM to either xterm-16color, xterm-88color, or xterm-256color.
# - rxvt is often built with support for 16 colors. You can try to set TERM to rxvt-16color.
# - konsole too is often built with support for 16 colors. You can try to set TERM to konsole-16color or xterm-16color.
ENV TERM xterm

RUN apt-get update && apt-get install -y\
    # Contains a minimal set of `PostgreSQL`_ binaries and headers requried for building 3rd-party applications for `PostgreSQL`.
    libpq-dev \
    # C and C++ client library to the memcached server.
    libmemcached-dev \
    # curl is a tool to transfer data from or to a server.
    curl \
    # libjpeg is a widely used C library for reading and writing JPEG image files.
    libjpeg-dev \
    # libpng is a library implementing an interface for reading and writing PNG.
    libpng-dev \
    # For font text.
    libfreetype6-dev \
    # Part of the OpenSSL project's implementation of the SSL and TLS cryptographic protocols for secure communication over the Internet.
    libssl-dev \
    # libmcrypt is the library which implements all the algorithms and modes found in mcrypt.
    libmcrypt-dev \
    # Editor tool.
    vim \
    # zlib is a library implementing the deflate compression method found in gzip and PKZIP.
    libzip-dev \
    zip \
    # icu is a C++ and C library that provides robust and full-featured Unicode and locale support.
    # g++ command is a GNU c++ compiler invocation command.
    zlib1g-dev libicu-dev g++ \
    # Do not install attach dependencies that doesn't use
    --no-install-recommends \
    # Remove depedency log of apt-get update
    && rm -r /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y pkg-config patch
ADD https://git.archlinux.org/svntogit/packages.git/plain/trunk/freetype.patch?h=packages/php /tmp/freetype.patch
RUN docker-php-source extract; \
  cd /usr/src/php; \
  patch -p1 -i /tmp/freetype.patch; \
  rm /tmp/freetype.patch

# configure gd library for php-extension for read write image
RUN docker-php-ext-configure gd \
    --with-gd \
    --with-jpeg-dir=/usr/include/ \
    --with-freetype-dir
    # --enable-gd-native-ttf

# configure intl for php - package for unicode and international language - go with libicu
RUN docker-php-ext-configure intl

# Install mongodb, xdebug
RUN pecl install mongodb \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install mcrypt-1.0.2 \
    && docker-php-ext-enable mcrypt

# Install extensions using the helper script provided by the base image for php
RUN docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install \
    bcmath \
    pdo_mysql \
    pdo_pgsql \
    gd \
    intl \
    zip

# set UID sticky bit for user www-data - www-data is a user/group set created specifically for web servers.
RUN usermod -u 1000 www-data

# go into /var/www/backend folder.
WORKDIR /var/www/project

# add config for php-fpm.
ADD ./.docker/php-fpm/config/conf.ini /usr/local/etc/php/conf.d
ADD ./.docker/php-fpm/config/php-fpm.conf /usr/local/etc/php-fpm.d/

# export to port 9000.
EXPOSE 9000

# run php-fpm command.
CMD [ "php-fpm" ]
