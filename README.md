##### Для запуска необходимо docker, docker-compose make

### Запуск проект PROD/DEV
 ```sh 
 make prod или make dev
 ```
### Запуск проекта LOCAL- для разработки
```sh
make local
```

Все docker файлы находятся в папке .docker. 
Если переменная окружения APP_ENV не LOCAL 
  по умолчанию всегда запускаются команды 
```sh 
composer install
php artisan cache:clear 
php artisan config:clear
php artisan migrate --force
```
Отредактировать последовательности запуска команд или добавть можно .docker/php-fpm/docker-php-entrypoint
