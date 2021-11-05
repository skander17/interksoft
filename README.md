# Interksoft


## Sobre nosotros

Interksoft es un sistema para la gestion interna en agencias de viajes, centralizando la información de ventas de boletos de la misma en un sólo sistema fácil, seguro y confiable para el usuario.cuenta con recursos propios para la gestion de registro de clientes, registor de venta de boletería, gestion de usuarios en sus distintos roles, entre otros servicios.
## Características

- Gestion para el registro y control de Clientes.
- Registro de ventas de boletos de avión.
- Gestion de usuarios y sus distintos roles.
- Información o estadística de las ventas de boletos y actividad de clientes.
- Exportación de documentos PDF con la información registrada.

## Tecnologías usadas

Interksoft se ejecuta sobre una serie de herramientas de última tecnología para la relización de todas sus tareas.

- [Laravel](https://laravel.com/) - Laravel es un marco de aplicación web con una sintaxis elegante y expresiva.
- PHP - Lenguaje del servidor version >= 8.0
- Composer   - Gestor de paquetes y librerias de PHP. 
- PostgreSQL - Motor de base de datos recomendado.
- Bootstrap  - Framework CSS para la interfaz de usuario (UI).
- jQuery - Librería JS que facilita la manipulación del DOM.


## Instalación


### Instalación mediante Docker

Interksoft cuenta con un entorno de desarrollo compatible con Docker.

```sh
cd interksoft
cp .env.example .env
docker-compose up -d 
```
Una vez haya terminado la instalación del stack ejecutar los siguientes comandos.


```sh
docker exec intercasas-php /bin/sh -c "php artisan key:generate && php artisan jwt:secret && php artisan migrate --seed"
```

Ya podemos acceder a nuestra sistema desde el navegador accediendo a la url [http://localhost:8090](http://localhost:8090)

### Instalación en maquina local.

```sh
cd interksoft
cp .env.example .env
composer install 
php artisan key:generate && php artisan jwt:private
php artisan migrate --seed
```

Para ejecutarse sobre el servidor de PHP usar la siguiente linea

```sh
php artisan serve
```

Ya podemos acceder a nuestra sistema desde el navegador accediendo a la url [http://localhost:8000](http://localhost:8000)
<!---

## Docker

Dillinger is very easy to install and deploy in a Docker container.

By default, the Docker will expose port 8080, so change this within the
Dockerfile if necessary. When ready, simply use the Dockerfile to
build the image.

```sh
cd dillinger
docker build -t <youruser>/dillinger:${package.json.version} .
```

This will create the dillinger image and pull in the necessary dependencies.
Be sure to swap out `${package.json.version}` with the actual
version of Dillinger.

Once done, run the Docker image and map the port to whatever you wish on
your host. In this example, we simply map port 8000 of the host to
port 8080 of the Docker (or whatever port was exposed in the Dockerfile):

```sh
docker run -d -p 8000:8080 --restart=always --cap-add=SYS_ADMIN --name=dillinger <youruser>/dillinger:${package.json.version}
```

> Note: `--capt-add=SYS-ADMIN` is required for PDF rendering.

Verify the deployment by navigating to your server address in
your preferred browser.

```sh
127.0.0.1:8000
```
-->

