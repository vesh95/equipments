install: up composer migrate

exec:
	@docker-compose exec web bash

up:
	@docker-compose up -d

down:
	@docker-compose down

migrate:
	@docker-compose exec web ./artisan migrate

composer:
	@docker-compose exec web composer install
