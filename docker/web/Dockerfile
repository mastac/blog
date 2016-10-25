FROM php:7.0-apache

ENV TERM xterm

RUN a2enmod rewrite

ADD ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Install Curl
RUN apt-get update && apt-get install -y \
    curl \
    libmcrypt-dev \
    libpng-dev \
    libjpeg-dev \
    mysql-client \
    nano \
    git \
    zip \
    unzip

# Configure extensions using the helper script provided by the base image
RUN docker-php-ext-configure \
    gd --with-jpeg-dir=/usr/include/

# Install extensions using the helper script provided by the base image
RUN docker-php-ext-install \
    pdo_mysql \
    mcrypt \
    gd

# Add the Node.js repo and install it
RUN curl -sL https://deb.nodesource.com/setup_4.x | bash -
RUN apt-get install -y nodejs

# Clean up, to free some space
RUN apt-get clean

# Install gulp and bower with NPM
RUN npm install -g npm
RUN npm install -g gulp bower

# Install Composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && echo "alias composer='/usr/local/bin/composer.phar'" >> ~/.bashrc

# Source the bash
RUN . ~/.bashrc

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN usermod -u 1000 www-data