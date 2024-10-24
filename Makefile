SHELL := /bin/bash
EXEC_PHP := docker compose exec -it php
ifeq (locally,$(firstword $(MAKECMDGOALS)))
	EXEC_PHP :=
endif

locally:;@:
.PHONY: locally

create: ## Собрать и запустить проект
	$(MAKE) up
	$(EXEC_PHP) php artisan key:generate
	$(MAKE) db-migrate
	$(MAKE) db-load

vendor: composer.json composer.lock ## Собрать vendor
	$(EXEC_PHP) composer install
	$(EXEC_PHP) touch vendor

up: var ## Пересобрать контейнеры
	docker compose up --build --detach --remove-orphans

	$(MAKE) vendor
.PHONY: up

down: ## Удалить контейнеры
	docker compose down --remove-orphans
.PHONY: down

start: var ## Запустить проект
	docker compose start
	$(MAKE) vendor
.PHONY: start

# Работа с БД
db-migrate: vendor ## Провести миграции
	$(EXEC_PHP) php artisan migrate
.PHONY: db

db-load: vendor ## Загрузить тестовые данные
	$(EXEC_PHP) php artisan db:seed --class=ProductSeeder
.PHONY: db 

# Проверки кода

check: lint psalm check-composer ## Запустить все проверки
.PHONY: check

lint: var vendor ## Проверить PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --dry-run --diff --verbose
.PHONY: lint

fixcs: var vendor ## Исправить ошибки PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --diff --verbose
.PHONY: fixcs

psalm: var vendor ## Запустить полный статический анализ PHP кода при помощи Psalm (https://psalm.dev/)
	$(EXEC_PHP) vendor/bin/psalm --no-diff $(file)
.PHONY: psalm

check-composer: composer-validate composer-audit composer-require composer-normalize  ## Запустить все проверки для Composer
.PHONY: check-composer

composer-validate: ## Провалидировать composer.json и composer.lock при помощи composer validate (https://getcomposer.org/doc/03-cli.md#validate)
	$(EXEC_PHP) composer validate --strict --no-check-publish
.PHONY: composer-validate

composer-require: vendor ## Обнаружить неявные зависимости от внешних пакетов при помощи ComposerRequireChecker (https://github.com/maglnet/ComposerRequireChecker)
	$(EXEC_PHP) vendor/bin/composer-require-checker check
.PHONY: composer-require

composer-unused: vendor ## Обнаружить неиспользуемые зависимости Composer при помощи composer-unused (https://github.com/icanhazstring/composer-unused)
	$(EXEC_PHP) vendor/bin/composer-unused
.PHONY: composer-unused

composer-audit: vendor ## Обнаружить уязвимости в зависимостях Composer при помощи composer audit (https://getcomposer.org/doc/03-cli.md#audit)
	$(EXEC_PHP) composer audit
.PHONY: composer-audit

composer-normalize: vendor ## Проверить, что composer.json отнормализован (https://github.com/ergebnis/composer-normalize)
	$(EXEC_PHP) composer normalize --dry-run --diff
.PHONY: composer-normalize

composer-normalize-fix: vendor ## Отнормализовать composer.json (https://github.com/ergebnis/composer-normalize)
	$(EXEC_PHP) composer normalize --diff
.PHONY: composer-normalize-fix

