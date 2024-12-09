# DESPLIEGUE PLATAFORMA WEB PGA

##
## Requerimientos

* Docker
* docker-compose

## Clonar el proyecto

```sh
git clone https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/PlantillaDeTrabajo.git
``

# Apuntar el proyecto al nuevo repositorio y subir los archivos

```sh
git remote set-url https://github.com/MUTUAL-DE-SERVICIOS-AL-POLICIA/{NombreProyecto}.git
git push -u origin main
``

## Instalación

```sh
sudo apt update
apt install docker
apt install docker-compose
``
* Verificar la instalación

```sh
docker --version
docker-compose --version
``
* Clonar Laradock

```sh
git clone https://github.com/Laradock/laradock.git
``

* Copiar los archivos de configuracion del laradock

```sh
cp -f docs/docker-compose.yml laradock/
cp -f docs/.env.example laradock/.env
```

* Modificar el archivo `.env` con las credenciales de acceso a la base de datos.
* Modificar el archivo `.env` de la carpeta laradock de acuerdo a los puertos que se irán a utilizar y el nombre del proyecto.
* Actualizar la documentacion README.md segun el proyecto

```sh
NGINX_HOST_HTTP_PORT=80
```

* Construir las imagenes:

```sh
docker-compose build --no-cache nginx redis workspace
```

* Levantar los contenedores:

```sh
docker-compose up -d nginx redis workspace
```

* Verificar que los contenedores se encuentren funcionando:

```sh
docker-compose ps -a
```

* Instalar las dependencias del proyecto

```sh
docker-compose exec workspace composer install
```

# Notas

* Se pueden verificar los log's de los contenedores levantados o hacer seguimiento en caso de que algun contenedor genere algun error

```sh
docker-compose logs nginx

docker-compose -f nginx
```

# Notas

* Para realizar las migraciones de forma correcta en la base de datos crear el Esquema 'store'

```sh
psql -U tu_usuario -d nombre_de_tu_base_de_datos
```
CREATE SCHEMA IF NOT EXISTS store;
