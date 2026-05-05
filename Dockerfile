FROM php:8.3-apache

# instalar dependencias
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip
# activar mod_rewrite
RUN a2enmod rewrite
# intalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# carpeta de trabajo de 
WORKDIR /var/www/html
# copiar proyecto
COPY . .
# configrar Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
# crear .env
RUN cp .env.example .env
# instalar dependencias 
RUN composer install
# instalar npm vite
RUN apt-get install -y nodejs npm
# permisos 
RUN chown -R www-data:www-data /var/www/html
# exponer puerto
EXPOSE 80
# prender Apache
CMD ["apache2-foreground"]

# corregir el dockerfile quitar dependencias innecesario, corregir el cmd y
# usar el apache, agregar el nuevo readme explicando como poder  ..... terminar el readme
