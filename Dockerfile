FROM php:8.3-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Activar mod_rewrite (necesario para Laravel)
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Configurar Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Crear .env
RUN cp .env.example .env

# Instalar dependencias 
RUN composer install

# Permisos 
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto
EXPOSE 80

# Arrancar Apache
CMD ["apache2-foreground"]

# corregir el dockerfile quitar dependencias innecesario, corregir el cmd y
# usar el apache, agregar el nuevo readme explicando como poder  ..... terminar el readme
