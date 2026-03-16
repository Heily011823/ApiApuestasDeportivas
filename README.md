# ApiApuestasDeportivas

API REST desarrollada con Laravel para gestionar apuestas deportivas.
Permite registrar usuarios, iniciar sesión, consultar eventos deportivos, ver cuotas y realizar apuestas.

## Tecnologías usadas

* PHP
* Laravel
* JWT para autenticación
* MySQL
* Postman para pruebas de la API

## Funcionalidades principales

* Registro de usuarios
* Inicio de sesión con JWT
* Autenticación de doble factor (2FA)
* Ver eventos deportivos
* Ver cuotas de apuestas
* Realizar apuestas
* Consultar apuestas realizadas
* Ver resultados de eventos
* Gestión de eventos, cuotas y resultados (solo administrador)

## Instalación

1. Clonar el repositorio

```
git clone https://github.com/Heily011823/ApiApuestasDeportivas.git
```

2. Entrar a la carpeta del proyecto

```
cd ApiApuestasDeportivas
```

3. Instalar dependencias

```
composer install
```

4. Copiar el archivo de entorno

```
cp .env.example .env
```

5. Generar la clave de la aplicación

```
php artisan key:generate
```

6. Configurar la base de datos en el archivo `.env`

7. Ejecutar migraciones

```
php artisan migrate
```

8. Iniciar el servidor

```
php artisan serve
```

## Documentación de la API

La documentación de los endpoints se encuentra en la carpeta:

```
docs/ApiApuestasDeportivas.postman_collection.json
```

Este archivo se puede importar en Postman para probar todos los endpoints.

## Autenticación

La API usa autenticación con JWT.
Después de iniciar sesión se debe enviar el token en los endpoints protegidos usando:

```
Authorization: Bearer TOKEN
```

## Autores

Proyecto desarrollado por:

Heily Yohana Rios Ayala

Maria Paz Puerta Acevedo

Universidad Autónoma de Manizales
Asignatura: Programación Backend
