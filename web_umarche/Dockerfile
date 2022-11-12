FROM php:8.1-apache
RUN apt update \
        && apt install -y g++ libicu-dev libpq-dev libzip-dev zip zlib1g-dev \
        && mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs