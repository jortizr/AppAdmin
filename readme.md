
BD: composer require symfony/orm-pack
plantillas frontend: composer require symfony/twig-pack
depurador: composer require symfony/debug-pack
comandos de consola: composer require symfony/maker-bundle --dev
composer require easycorp/easyadmin-bundle


instalar todas las dependencias:
composer install

crear variables de entorno
cp .env .env.local

configurar la BD
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

carga de datos (opcional)
php bin/console doctrine:fixtures:load

instalar dependencias frontend
npm install
npm run dev

limpiar la cache
php bin/console cache:clear

ejecutar el servidor
symfony server:start
# o
php -S localhost:8000 -t public
