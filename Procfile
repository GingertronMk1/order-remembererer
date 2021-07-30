web: vendor/bin/heroku-php-apache2 public/

release: php artisan migrate --force && php artisan route:list --columns=Method --columns=URI --columns=Name
