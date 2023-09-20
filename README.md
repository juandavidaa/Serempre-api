
## Acerca de Serempre Api

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

## Requerimientos

Serempre Api requiere un archivo de entorno ``.env``. Para esto tenemos un archivo de ejemplo ``.env.example``, podemos renombrar este archivo a ``.env`` y luego asignar los valores necesarios a las variables de entorno, necesarias para el funcionamiento de la API.

Aquí una lista con las variables de entorno que necesitamos asignar en nuestro archivo ``.env``

````.envfile
FRONT_APP_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=serempre
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=jdaa482@gmail.com
MAIL_FROM_NAME=${APP_NAME}
````
## Como ejecutar

Primero instalamos las dependencias.

`` composer install ``

Luego creamos nuestra key para autenticarnos por medio de JWT.

`` php artisan jwt:secret ``

Ejecutamos las migraciones y el seed de la base de datos con el custom command

`` php artisan db:init``

Por ultimo podemos a correr el api

`` php artisan serve ``
