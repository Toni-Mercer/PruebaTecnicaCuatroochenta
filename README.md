# Prueba técnica Cuatroochenta



### Creación del proyecto

Creación de un proyecto en Symfony.

> La versión del binario es la 5.5.8
>
> La versión de symfony del proyecto es 6.3.4

```bash
$ symfony new wineMeasurements
```

![](https://github.com/Toni-Mercer/PruebaTecnicaCuatroochenta/blob/master/public/assets/images/screenshoots/Screenshot%20from%202023-09-28%2017-48-32.png?raw=true)

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
- SensorController: todos los enpoints para gestionar sensores y tipos de sensores.

```bash
$ php bin/console make:controller Home
$ php bin/console make:controller Login
$ php bin/console make:controller Public
$ composer require form validator twig-bundle
$ php bin/console make:registration-form
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-30 11-07-48.png)

> añadimos al formulario de login un path() a app_register para que se puedan dar de alta.



#### Creación de comandos en symfony.

Creamos un comando para generar un dumy user. Y otro para generar una medición y ver como aparece en la tabla con el autoupdate.

``` bash
php bin/console app:create-user demo@mail.com 123456789
php bin/console app:create-reading verdejo 'Faustino V' blanco 17.0 5.0 6.2 'Observaciones aqui.'
```

![](./public/assets/images/screenshoots/Screenshot from 2023-09-30 12-34-53.png)



#### Estructura de los templates

Creamos una página llamada `base.html.twig` que contenga la estructura básica de un html, diferenciando los bloques `head`, `header`, `body` y `footer` entre otros. Estos bloques contienen código compartido entre las diferentes páginas. Podríamos duplicar esta estructura para tener una parte pública y privada totalmente diferente.

![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 17-44-04.png)





#### Creación de los cotroladores con sus endpoints

Como no tenemos parte pública hacemos un redirect al `/login` directamente en el `PublicController`.

![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 18-12-59.png)



En `HomeController` creamos los enpoints `/home`, `/measurements` donde Home devuelve una vista y measurements devuelve un json que será cargado vía ajax a la tabla de lecturas.

![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 18-03-12.png)



Para limitar las lecturas a una por día al hacer login mostramos el botón para añadir una lectura solo si en el log de lecturas `reading_log` no hay ninguna entrada de hoy. 

![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 18-27-31.png)

> Al crear un registro una vez vuelvas al login el botón no va a aparecer.

![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 18-28-07.png)


![](/home/toni/PhpStormProjects/wineMeasurements/public/assets/images/screenshoots/Screenshot from 2023-10-02 18-27-47.png)

#### ReadingsLog

He creado `ReadingsLog` para poder limitar las lecturas a una al día.
