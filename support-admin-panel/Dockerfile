# ---------- مرحله Node Builder (فرانت‌اند) ----------
FROM node:20-alpine AS node_builder

WORKDIR /app

# بسته‌های npm رو کپی و نصب می‌کنیم
COPY package*.json ./
RUN npm install

# کل پروژه رو کپی می‌کنیم
COPY . .

# build فرانت‌اند با Vite
RUN npm run build

# ---------- مرحله PHP Builder (بک‌اند) ----------
FROM php:8.3-fpm AS php_builder

# نصب ابزارها و اکستنشن‌های PHP ضروری
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql bcmath gd intl zip opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# کپی سورس پروژه به کانتینر
COPY . .

# نصب dependencies PHP
RUN composer install --no-dev --optimize-autoloader

# کپی فایل‌های ساخته شده توسط Node
COPY --from=node_builder /app/public/build ./public/build

# تنظیمات مالکیت و مجوزها
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]