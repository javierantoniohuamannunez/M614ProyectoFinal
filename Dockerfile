FROM php:8.3-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Crear .env automáticamente
RUN cp .env.example .env

# Instalar dependencias de PHP
RUN composer install

EXPOSE 8000

# Comandos que se ejecutan al iniciar el contenedor
CMD npm install && npm run build && php artisan key:generate && php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000