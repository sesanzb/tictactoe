# Tres en raya

Descripción de la tarea:
- El juego debe componerse de una tabla 3x3.
- Dos jugadores, uno representado por la marca O y el otro por X.
- El primer jugador en alcanzar 3 marcas seguidas, ya sean horizontal, verticalmente o en diagonal gana.
- Los jugadores juegan en el mismo ordenador, una vez clica uno le toca al otro, no se necesita instalación previa.
 

### Requerimientos previos

* **Composer**

Será necesario tener Composer instalado globalmente.
Para Windows, descargar el [instalador ejecutable de Composer](https://getcomposer.org/download) y seguir los pasos indicados
Para Linux o Mac OS X, ejecutar los siguientes comandos:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

* **Servidor Web**

Si el equipo no dispone de servidor web:

* [Servidor integrado de Symfony](https://symfony.com/doc/current/setup/built_in_web_server.html) (opción recomendada)
* [XAMPP (7.4.1)](https://www.apachefriends.org/es/download.html) 
* PHP (7.4.X) y Apache/Ngix por separado


### INSTALACIÓN:

En la ruta preferida, descargar el proyecto y ejecutar la instalación:

```bash
$ git clone https://github.com/sesanzb/tictactoe.git
$ cd tictactoe/
$ composer install
$ php bin/console doctrine:migrations:migrate
```
##### NOTA ##### 
> El último comando requiere la respuesta del usuario (y)

### INICIO (Servidor integrado):

Dentro de la raíz del proyecto, iniciar el servidor web interno de PHP:

```bash
$ symfony server:start
```
Se puede acceder localmente al proyecto, ingresando a tu [localhost](http://localhost:8000).



##### Notas finales: #####

> Se ha utilizado una BD Sqlite para simplificar el despliegue.

> No se han tenido en cuenta algunas validaciones de datos ni cuestiones de seguridad.

> El jugador únicamente introduce su apodo que es único en este caso y no se requieren más datos por simplificar.

> En la carpeta src/Migrations se puede encontrar el dump de la BD.
