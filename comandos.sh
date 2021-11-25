php bin/console doctrine:schema:update --force
php bin/console cache:clear --env=prod
php bin/console cache:clear --env=dev
sudo chown www-data:www-data var/ -R
