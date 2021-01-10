
set -e

sudo chmod a+w -R siteroot/storage
cp docker/.env siteroot/.env

docker-compose exec -w /siteroot/siteroot web composer install
docker-compose exec -w /siteroot/siteroot web composer dump-autoload
docker-compose exec -w /siteroot/siteroot web php artisan migrate --seed