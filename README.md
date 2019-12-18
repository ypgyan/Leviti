# Leviti-API

Projeto para gerência de membresia em igrejas.

Utilizando:
- Docker (https://docs.docker.com/)
- Laravel Lumen (https://lumen.laravel.com/docs/6.x)
- Swoole (https://www.swoole.co.uk/)
- composer (https://getcomposer.org/)
- ypg-api (https://github.com/ypgyan/ypg-api)

Comandos iniciais após clonar o repositório:
- Composer install dentro da pasta leviti
- php artisan migrate

Obs: Os comandos devem ser rodados dentro do container do PHP caso esteja usando docker.

Levantando o servidor

Php:
- php -S 0.0.0.0:3000 -t public

Swoole:
- php artisan swoole:http start
-- O host e a porta usados pelo swoole estão no .env.example

Obs: O comando deve ser rodado dentro da pasta leviti
