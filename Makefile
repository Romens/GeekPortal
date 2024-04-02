THIS_FILE := $(lastword $(MAKEFILE_LIST))

.SILENT:

.PHONY: help
help:
	clear
	@sed -ne '/@sed/!s/## //p' $(MAKEFILE_LIST)

## ----------------------------------------------------------------------
## Environment commands list:
## ----------------------------------------------------------------------

.PHONY: start
start: init down up composer_install npm_install migrate pre_import ide pint test watch## [🔨] Start local development
start_backend: init down up composer_install npm_install migrate pre_import ide pint test open php ## [🔨] Start local development
start_frontend: init down up composer_install npm_install migrate pre_import test pint open watch ## [🔨] Start local development
ready: up build open_prod

.PHONY: up
up: ## [🔨] Start app
	docker-compose up -d --build

.PHONY: open
open:
	open http://localhost:3000

.PHONY: open_prod
open_prod:
	open http://localhost/

.PHONY: init
init:
	cp -R -n -p .env.dist .env || true

.PHONY: down
down: ## Down app
	docker-compose down --remove-orphans

.PHONY: test
test: phpunit phpstan ## Run backend tests

.PHONY: migrate
migrate: ## Run migrations
	docker-compose exec -it php php artisan migrate --seed

.PHONY: phpunit
phpunit: ## Run phpunit tests
	docker-compose exec -it php php artisan test --parallel --coverage


.PHONY: php
php: ## Run php shell
	docker-compose exec -it php sh

.PHONY: watch
watch: ## Run php shell
	docker-compose exec -it node yarn dev

.PHONY: build
build: ## Run php shell
	docker-compose exec -it node yarn build

.PHONY: composer_install
composer_install: ## Run php shell
	docker-compose run -it php php -r "file_exists('.env') || copy('.env.dist', '.env'); "
	docker-compose run -it --rm composer install --ignore-platform-reqs


.PHONY: npm_install
npm_install: ## Run php shell
	docker-compose run -it --rm node npm install
	docker-compose run -it --rm node yarn

.PHONY: node
node: ## Run node shell
	docker-compose run -it --rm node sh

.PHONY: pre_import
pre_import: ## Run your scripts before running laravel
	echo "Your scripts"
	docker-compose exec -it php php artisan key:generate
	docker-compose exec -it php php artisan passport:install

.PHONY: phpstan
phpstan: ## Run phpstan analysis
	docker-compose run -it --rm php ./vendor/bin/phpstan analyse --memory-limit 512M

.PHONY: pint
pint: ## Run Pint - PHP code style fixer
	docker-compose run -it --rm php ./vendor/bin/pint

.PHONY: ide
ide: ## Run ide:helper for local development
	docker-compose exec -it php php artisan ide-helper:eloquent
	docker-compose exec -it php php artisan ide-helper:generate
	docker-compose exec -it php php artisan ide-helper:meta
	docker-compose exec -it php php artisan ide-helper:models -n
