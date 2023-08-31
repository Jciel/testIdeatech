
d-up:
	docker-compose up

d-build:
	docker-compose build

migrate:
	docker-compose exec php php artisan migrate

migrate-refresh:
	docker-compose exec php php artisan migrate:refresh

migrate-down:
	docker-compose exec php php artisan migrate:fresh

db-seeder:
	docker-compose exec php php artisan db:seed

test:
	docker-compose exec php vendor/bin/phpunit

testfile:
	 docker-compose exec php vendor/bin/phpunit --filter $(file)

