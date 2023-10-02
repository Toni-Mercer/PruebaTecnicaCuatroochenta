# Prueba técnica Cuatroochenta



### Creación del proyecto

Creación de un proyecto en Symfony.

> La versión del binario es la 5.5.8
>
> La versión de symfony del proyecto es 6.3.4

```bash
$ symfony new wineMeasurements
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 17-48-32.png)

#### Instalamos los módulos necesarios vía composer

> secure-bundle para gestion de login, session 

```bash
$ composer require symfony/security-bundle
$ composer require symfony/orm-pack
$ composer require --dev symfony/maker-bundle
$ composer require symfony/asset
$ composer require --dev symfony/profiler-pack
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 17-54-41.png)



#### Creación de DBB y usuario web

Creación de DBB

```sql
CREATE DATABASE wineMeasurements;
```

Creación de usuario web

```sql
CREATE USER 'wine-www'@localhost IDENTIFIED BY 'HoV0=gN4';
GRANT ALL PRIVILEGES ON wineMeasurements.* TO 'wine-www'@localhost;
```



Configuración de symfony con MariaDB 

> Editamos .env directamente.
>
> Descomentamos el DATABASE_URL con el controlador de mariadb, ajustamos versión y credenciales. 

```text
DATABASE_URL="mysql://wine-www:HoV0=gN4@127.0.0.1:3306/wineMeasurements?serverVersion=10.11.3-MariaDB&charset=utf8mb4"
```



#### Creación de los Entity 

> Creamos el user con el script propio y luego generamos las otras entidades para interactuar con la base de datos.

```bash
$ php bin/console make:user
$ php bin/console make:entity
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 18-29-07.png)

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 18-38-56.png)



El objeto queda mapeado a la DBB. Las columnas y variables no tienes porque coincidir.

> Por defecto programo en inglés. Todo y que suelo comentar en Inglés también, entiendo que mis compañeros de trabajo pueden no hablarlo y por lo tanto me ajustaré a la metodología de la empresa.

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 18-44-40.png)

Procedemos a crear las tablas en la DBB

```bash
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

usando `show tables` podemos ver que todo ha ido bien:

![](./public/assets/images/screenshoots/Screenshot from 2023-09-28 19-06-56.png)



#### Procedemos a crear los primeros controladores

Preparamos 4 controladores:

- HomeController: endpoints para la parte logueada
- LoginController: endpoints de login e logout
- PublicController: endpoints para la parte no autenticada
- RegisterController: endpoints para registrarse 

```bash
$ php bin/console make:controller Home
$ php bin/console make:controller Login
$ php bin/console make:controller Public
$ composer require form validator twig-bundle
$ php bin/console make:registration-form
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-30 11-07-48.png)

> añadimos al formulario de login un path() a app_register para que se puedan dar de alta.

Procedemos a crear un controlador paga gestionar los sensores

```bash
$ php bin/console make:controller Sensors
```



#### Creación de comandos en symfony.

> Creamos un comando para generar un dumy user.

``` bash
php bin/console app:create-user demo@mail.com 123456789
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-30 12-34-53.png)



#### Estructura de los templates

base.html.twig tiene la estructura básica de un html y en donde definimos bloques de código básicos de un html. 

Posteriormente definimos los fragmentos individualmente y anadimos el código que se va a repetir en cada página.

