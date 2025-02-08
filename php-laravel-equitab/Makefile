up:
	docker compose up -d
down:
	docker compose down --remove-orphans
build:
	docker compose build
log:
	docker compose logs laravel
migrate:
	docker compose exec laravel php artisan migrate
fresh:
	docker compose exec laravel php artisan migrate:fresh --seed
seed:
	docker compose exec laravel php artisan db:seed
bash:
	docker compose exec laravel /bin/bash
ide-helper:
	php artisan clear-compiled
	php artisan ide-helper:generate