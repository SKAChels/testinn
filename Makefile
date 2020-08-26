up: docker-up
down: docker-down
stop: docker-stop
start: docker-start
restart: docker-restart
build: docker-build
init: docker-down-clear docker-build docker-up app-init

build-nginx:
	docker-compose build nginx

build-php:
	docker-compose build php

build-php-with-xdebug:
	docker-compose build --build-arg ENV=DEV php

docker-up:
	docker-compose up --detach --remove-orphans

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down --volumes --remove-orphans

docker-stop:
	docker-compose stop

docker-start:
	docker-compose start

docker-restart:
	docker-compose restart

docker-build:
	docker-compose build

up-php:
	docker-compose up --detach php

up-nginx:
	docker-compose up --detach nginx

app-init: composer-install

composer-install:
	docker-compose run --rm composer install

composer-install-no-dev:
	docker-compose run --rm composer install --no-dev

shell-php:
	docker-compose exec php bash

shell-nginx:
	docker-compose exec nginx bash

shell-composer:
	docker-compose run --rm composer bash

log-nginx:
	docker-compose logs --follow nginx

log-php:
	docker-compose logs --follow php

log-composer:
	docker-compose logs --follow composer

logs:
	docker-compose logs --follow
