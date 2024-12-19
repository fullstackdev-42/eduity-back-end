#!make
include .env
export $(shell sed 's/=.*//' .env)

apache_container=apache
php_container=php
mysql_container=eduity-mysql

HOST_USER_ID=$$(id -u)
ifeq ($(shell uname -s),Linux)
HOST_GROUP_ID=$$(id -g)
else
HOST_GROUP_ID=${HOST_USER_ID}
endif
HOST_USERNAME=$$(whoami)

BARG = --build-arg HOST_USER_ID=${HOST_USER_ID} --build-arg HOST_GROUP_ID=${HOST_GROUP_ID} --build-arg HOST_USERNAME=${HOST_USERNAME}
USEROPT = --user ${HOST_USER_ID}:${HOST_GROUP_ID}


status:
	docker ps

up:
	docker-compose up -d

new: build backend-build frontend-build

build:
	docker-compose rm -sf
	docker-compose down -v --remove-orphans
	docker-compose build $(BARG) ${apache_container}
	docker-compose build $(BARG) ${php_container}

	#docker-compose up -d

frontend-build: up
	docker-compose exec ${USEROPT} ${php_container} npm install
	docker-compose exec ${USEROPT} ${php_container} npm run dev

backend-build: up
	docker-compose exec ${USEROPT} ${php_container} composer install

create-database: up
	docker-compose exec ${USEROPT} ${php_container} php bin/console doctrine:database:create
	docker-compose exec ${USEROPT} ${php_container} php bin/console doctrine:migrations:migrate
	docker-compose exec ${USEROPT} ${php_container} php bin/console app:user:create --super-admin

down:
	docker-compose down

jumpin: up
	docker-compose exec ${USEROPT} ${php_container} bash

tail-logs:
	docker-compose logs -f ${php_container}

clean:
	docker system prune

generate_jwt_keys:
	#!!INSECURE KEYS!!
	docker-compose exec ${USEROPT} ${php_container} mkdir -p config/jwt
	docker-compose exec ${USEROPT} ${php_container} openssl genrsa -passout pass:${EDUITY_JWT_PASSPHRASE} -out config/jwt/private.pem -aes256 4096
	docker-compose exec ${USEROPT} ${php_container} openssl rsa -passin pass:${EDUITY_JWT_PASSPHRASE} -pubout -in config/jwt/private.pem -out config/jwt/public.pem

import_onet_data:
	mkdir -p docker/docker-entrypoint-initdb.d
	rm -rf docker/docker-entrypoint-initdb.d/*
	wget -O docker/docker-entrypoint-initdb.d/onet.zip ${EDUITY_ONET_DOWNLOAD}
	unzip -j -u -d docker/docker-entrypoint-initdb.d/ docker/docker-entrypoint-initdb.d/onet.zip
	for file in $$(ls docker/docker-entrypoint-initdb.d/*.sql); do \
		docker exec -i ${mysql_container} sh -c 'exec mysql --database "${EDUITY_POSTGRES_DB}" -uroot -p"${EDUITY_MYSQL_ROOT_PASSWORD}"' < $${file}; \
	done

clean-all:
	docker system prune -a

%:
	@: