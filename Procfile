web: vendor/bin/heroku-php-apache2 public/
queue_runner: php artisan queue:restart && php artisan queue:work

release: php artisan migrate --force && php artisan route:list --columns=Method --columns=URI --columns=Name
