up:
	docker compose up -d
down:
	docker compose down --remove-orphans
build:
	docker compose build
log:
	docker compose logs laravel-server
migrate:
	docker compose exec laravel-server php artisan migrate
fresh:
	docker compose exec laravel-server php artisan migrate:fresh --seed
seed:
	docker compose exec laravel-server php artisan db:seed
bash:
	docker compose exec laravel-server /bin/bash
ide-helper:
	docker compose exec laravel-server php artisan clear-compiled
	docker compose exec laravel-server php artisan ide-helper:models -E
	docker compose exec laravel-server php artisan ide-helper:generate