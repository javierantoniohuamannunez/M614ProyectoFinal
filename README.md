# Proyecto con Docker - M614

Aplicación web desarrollada con Laravel que permite gestionar diferentes entidades educativas de forma sencilla y organizada:

- Alumnes
- Professors
- Mòduls
- Grups

El sistema incluye autenticación de usuarios y control de acceso basado en roles, lo que nos ayuda a restringir ciertas funciones dependiendo el tipo de usuario.

## Tecnologías utilizadas

Este proyecto se desarrollo utilizando las estas tecnologias:

- PHP 8.3
- Laravel
- MySQL
- Docker
- Apache

## Requisitos

Antes de comenzar, asegúrate de tener instalado en tu sistema:

- Docker
- Docker Compose
- Git

## Instalación de Docker y Docker Compose

### 🔹 En Ubuntu / Linux

Actualizar paquetes:

```bash
sudo apt update
```

Instalar Docker:

```bash
sudo apt install docker.io -y
```

Activar y arrancar Docker:

```bash
sudo systemctl enable docker
sudo systemctl start docker
```

Instalar Docker Compose:

```bash
sudo apt install docker-compose -y
```

Comprobar instalación:

```bash
docker --version
docker-compose --version
```

## Instalación y ejecución del proyecto

1. Clonar el repositorio:

```bash
git clone https://github.com/javierantoniohuamannunez/M614ProyectoFinal.git
cd M614ProyectoFinal
```

2. Construir y levantar los contenedores:

```bash
docker-compose up --build
```

Este comando descargará las imágenes necesarias, contruira el entorno y levantara los servicios como lavarvel y mysql

3. Se puede acceder a la aplicación desde el navegador:

```
http://localhost:8000
```

## Configuración inicial

Una vez el proyecto funcione, se necesita realizar algunas configuraciones iniciales:

### Compilación de assets (Vite)

Antes de ejecutar el proyecto, es necesario compilar los recursos frontend:

```bash
npm install
npm run build
```

Esto generará la carpeta public/build necesaria para que Laravel funcione correctamente.

Generar la clave de la aplicación Laravel:

```bash
docker exec -it M614Proyecto php artisan key:generate
```

Ejecutar migraciones para crear las tablas en la base de datos:

```bash
docker exec -it M614Proyecto php artisan migrate
```

(Opcional) Poblar la base de datos con datos de prueba:

```bash
docker exec -it M614Proyecto php artisan db:seed
```

## Autenticación y roles

El sistema incluye un sistema de autenticación que permite:

- Registro de usuarios
- Inicio de sesión
- Protección de rutas

Además, se implementa control de acceso por roles:

- Usuarios normales: acceso limitado
- Administradores: acceso completo a la gestión de datos

## Estructura del proyecto

El proyecto sigue la estructura estándar de Laravel:

- `app/Http/Controllers` → Controladores que gestionan la lógica de la aplicación
- `resources/views` → Vistas Blade o lo que ve el usuario
- `routes/web.php` → Donde se defina todas las rutas web
- `database/migrations` → Migraciones de base de la datos
- `Dockerfile` → Configuración del contenedor de Laravel
- `docker-compose.yml` → Definición de servicios de Laravel y MySQL

## Uso de Docker en el proyecto

Docker permite ejecutar la aplicación en un entorno aislado sin necesidad de instalar dependencias manualmente en el sistema.

El proyecto utiliza:

- Apache como servidor web
- PHP 8.3 para ejecutar Laravel
- MySQL como sistema de base de datos

Ventajas de usar Docker:

- Muy facil el despliegue
- Evita conflictos de versiones

## Comandos útiles

Parar los contenedores:

```bash
docker-compose down
```

Ver contenedores activos:

```bash
docker ps
```

Acceder al contenedor:

```bash
docker exec -it M614Proyecto bash
```
