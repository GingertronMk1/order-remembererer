web: vendor/bin/heroku-php-apache2 public/

release: php artisan migrate --seed --force && php artisan route:list --columns=Method --columns=URI --columns=Name
