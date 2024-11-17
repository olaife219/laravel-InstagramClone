#!/usr/bin/env bash

# Update and install PHP and required extensions
apt-get update && apt-get install -y php-cli php-mbstring php-xml unzip curl git

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Run Laravel commands
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
