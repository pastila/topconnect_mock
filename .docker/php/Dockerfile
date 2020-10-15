FROM php:7.3-fpm

ARG GROUP_ID
ARG USER_ID
ARG USER_NAME

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

RUN apt-get update && apt-get install -y \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clone id_rsa
RUN mkdir -p /home/$USER_NAME/.ssh
ADD id_rsa /home/$USER_NAME/.ssh/id_rsa
RUN chmod 0664 /home/$USER_NAME/.ssh/id_rsa
RUN echo "Host git.accurateweb.ru\n\t HostName git.accurateweb.ru\n\t Port 2022\n" >> /home/$USER_NAME/.ssh/config

RUN mkdir -p /home/$USER_NAME/.composer
#ADD auth.json /home/$USER_NAME/.composer/auth.json
#RUN chmod 0664 /home/$USER_NAME/.composer/auth.json

# Add user for laravel application
RUN groupadd -g $GROUP_ID $USER_NAME
RUN useradd -u $USER_ID -ms /bin/bash -g $USER_NAME $USER_NAME
# Change current user to $USER_NAME
USER $USER_NAME

WORKDIR /var/www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

# Run and add ssh key
RUN eval $(ssh-agent -s) && ssh-add /home/$USER_NAME/.ssh/id_rsa