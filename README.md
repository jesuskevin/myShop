# myShop
## Prueba tecnica relaizada con PHP y Laravel

Este proyecto es la presentacion de una prueba tecnica para una vacante como desarrollador PHP/LAravel.

#### Este es el objetivo:
Crear una aplicación utilizando el framework Laravel que tenga las siguientes funcionalidades:
+ control de acceso de usuarios
+ registros de logs 
+ integración del paquete Cashier para gestionar pagos.

El proyecto que lleva por nombre myShop consiste en una pequeña simulacion de una tienda de libros.

#### Existen dos tipos de usuarios:
+ Administrador - quien puede crear, editar y eliminar libros.
+ Miembro - puede ver los libros creados por el administrador y comprarlos.

#### Herramientas utilizadas:
+ Version de Laravel utilizada: 10.14.1
+ Version de PHP: 8.1.6
+ Servidor: XAMPP - Apache & MySQL
+ Paquete Laravel Cashier
+ Laravel Ui
+ Bootstrap 5

#### Configuracion del proyeycto
+ Clonar el repositorio: correr el siguiente comando en su terminal 'git clone https://github.com/jesuskevin/myShop.git'
+ Luego ingresamos a la carpeta del proyecto mediante la terminal instalar todas las depencias de composer con el comando: 'composer install' en su terminal (si utiliza Visual Studio Code puede abrir una terminal con las teclas ctrl + `)
+ Lo mismo con las dependencias de node, utilizar el comando 'npm install' en su terminal
+ El siguiente paso es crear un archivo que lleve por nombre .env en la raiz del proyecto y copiar todo lo que esta en el archivo .env.example al nuevo archivo ya creado
+ Luego de esto utilizamos el comando 'php artisan key:genrate' en la terminal para configurar el APP_KEY del proyecto
+ (opcional) cambiar el nombre de la aplicacion en la variable APP_NAME del archivo .env. En mi caso seria myShop
+ Vamos a nuestro administrador de base de datos y creamos una, el nombre que utilizemos lo vamos a poner en la variable DB_DATABASE de nuestro archivo .env (si utilizas otra configuracion debes de cambiar las demas variables de acuerdo a ellas y al motor de base de datos a utilizar, en mi caso es MySQL)
+ luego de esto configuramos Laravel cashier y stripe poniendo las siguientes variables en nuestro archivo .env:
STRIPE_KEY=tu-api-key-de-stripe
STRIPE_SECRET=tu-api-secret-de-stripe
puedes acceder a este link para obtener tus claves de acceso 'https://dashboard.stripe.com/test/apikeys' en caso de no tener un cuenta primero debes de registrarte.
+ Ya con nuestra base de datos creada y todo en orden, vamos a utilizar el comando 'php artisan migrate --seed' en nuestra terminal para crea todas las tablas y a su vez crear un usuario administrador por defecto.
+ En una consola utilizaremos el comando 'npm run dev' para compilar todos nuestros archivos del fronted y correr un servidor de prueba y la dejamos corriendo.
+ Ya por ultimo creamos una nueva terminal (usando el comando ctrl + shift + ` en vscode) y en esta vamos a ejecutar el comando 'php artisan serve' para ejecutar un servidor de desarrollo y por igual dejamos la consola con el proceso corriendo. (Tendriamos dos terminales corriendo dos procesos distintos).

Si la configuracion fue correcta, accediendo al enlace 'http://127.0.0.1:8000' veriamos el proyecto en marcha, donde la pagina de inicio de sesion es la pagina principal.
Podemos inicicar session con el usuario administrador existente en la base de datos
email: admin@myshop.com
password: password