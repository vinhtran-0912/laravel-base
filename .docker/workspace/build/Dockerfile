FROM ubuntu:16.04

MAINTAINER Nguyen Khac Duy Ngoc <nguyenkhacduyngoc@gmail.com>

RUN DEBIAN_FRONTEND=noninteractive
# Install "software-properties-common" (for the "add-apt-repository")
RUN apt-get update && apt-get install -y \
    software-properties-common locales

RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

# Add the "PHP 7" ppa
RUN add-apt-repository -y \
    ppa:ondrej/php

# Install PHP-CLI 7, some PHP extentions and some useful Tools with APT
RUN apt-get update && apt-get install -y --force-yes \
        php7.3-cli \
        php7.3-common \
        php7.3-curl \
        php7.3-json \
        php7.3-xml \
        php7.3-mbstring \
        php7.3-mysql \
        php7.3-pgsql \
        php7.3-sqlite \
        php7.3-sqlite3 \
        php7.3-zip \
        php7.3-memcached \
        php7.3-gd \
        php7.3-fpm \
        php7.3-xdebug \
        php7.3-bcmath \
        php7.3-intl \
        php7.3-dev \
        libcurl4-openssl-dev \
        libedit-dev \
        libssl-dev \
        libxml2-dev \
        xz-utils \
        sqlite3 \
        libsqlite3-dev \
        git \
        curl \
        vim \
        nano \
        net-tools \
        pkg-config \
        iputils-ping

RUN apt-get install -y libmcrypt-dev && \
    pecl install mcrypt-1.0.2
RUN echo "extension=mcrypt.so" >> /etc/php/7.3/cli/php.ini

# remove load xdebug extension (only load on phpunit command)
RUN sed -i 's/^/;/g' /etc/php/7.3/cli/conf.d/20-xdebug.ini

# Add bin folder of composer to PATH.
RUN echo "export PATH=${PATH}:/var/www/laravel/vendor/bin:/root/.composer/vendor/bin" >> ~/.bashrc

# Load xdebug Zend extension with phpunit command
RUN echo "alias phpunit='php -dzend_extension=xdebug.so /var/www/laravel/vendor/bin/phpunit'" >> ~/.bashrc

# Install mongodb extension
RUN pecl channel-update pecl.php.net && pecl install mongodb
RUN echo "extension=mongodb.so" >> /etc/php/7.3/cli/php.ini

# Install Nodejs
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g gulp-cli bower eslint babel-eslint eslint-plugin-react yarn

# Install SASS
RUN apt-get install -y ruby ruby-dev \
    && gem install sass

# Install Composer, PHPCS and Framgia Coding Standard,
# PHPMetrics, PHPDepend, PHPMessDetector, PHPCopyPasteDetector
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/app
