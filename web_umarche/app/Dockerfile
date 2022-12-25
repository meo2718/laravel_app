# image
FROM php:8.1-apache
# Laravelの依存PHPモジュールのInstall
# Laravelで必要なmodRewriteを有効化
RUN apt update \
        && apt-get install -y wget git unzip libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        && mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled
# Install MySQL
RUN docker-php-ext-install pdo pdo_mysql
# コンテナの作業ディレクトリを指定
WORKDIR /var/www/html
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
# Install node.js,InterventionImage
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install -j$(nproc) gd \