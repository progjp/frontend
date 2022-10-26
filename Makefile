DC := docker compose exec
FPM := $(DC) php-fpm

start:
	@docker compose up -d

stop:
	@docker compose down

ssh:
	@$(FPM) bash