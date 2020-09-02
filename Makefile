up: docker-up
down: docker-down
stop: docker-stop
start: docker-start
restart: docker-restart
build: docker-build
init: docker-down-clear docker-build docker-up app-init

build-php:
	docker-compose build php

build-node:
	docker-compose build node

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

up-node:
	docker-compose up --detach node

app-init: composer-install npm-install npm-build

composer-install:
	docker-compose run --rm composer install

composer-install-no-dev:
	docker-compose run --rm composer install --no-dev

npm-install:
	docker-compose exec node npm install

npm-build:
	docker-compose exec node npm run build

npm-build-dev:
	docker-compose exec node npm run serve

shell-php:
	docker-compose exec php bash

shell-nginx:
	docker-compose exec nginx bash

shell-composer:
	docker-compose run --rm composer bash

shell-node:
	docker-compose exec node sh

log-nginx:
	docker-compose logs --follow nginx

log-php:
	docker-compose logs --follow php

log-composer:
	docker-compose logs --follow composer

logs:
	docker-compose logs --follow
