release: php bin/console cache:clear && php bin/console cache:warmup && php bin/console doctrine:migrations:migrate --no-interaction
web: vendor/bin/heroku-php-apache2 public/
