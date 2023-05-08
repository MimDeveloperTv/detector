VERSION ?= latest
REGISTRY ?= git.wki.ir:5050/idpay/backend/qr-detector/app
DOCKERFILE ?= docker/prod/Dockerfile

# GENERAL ------------------------------------------

.PHONY: help
help:
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*:" | awk -F: '{ print $$1 }'

.PHONY: health
health:
	php artisan health:check --no-notification

.PHONY: migrate
migrate:
	php artisan migrate --force
	php artisan db:seed --force

.PHONY: optimize
optimize:
	php artisan optimize
	php artisan event:cache

# COMMAND ------------------------------------------

# QUEUE-WORKER -------------------------------------

# DOCKER -------------------------------------------

.PHONY: docker-build
docker-build:
	docker build . --force-rm --compress --file ${DOCKERFILE} --target cli --tag ${REGISTRY}/cli:${VERSION}
	docker build . --force-rm --compress --file ${DOCKERFILE} --target fpm_server --tag ${REGISTRY}/fpm_server:${VERSION}
	docker build . --force-rm --compress --file ${DOCKERFILE} --target web_server --tag ${REGISTRY}/web_server:${VERSION}

.PHONY: docker-build-swoole
docker-build-swoole:
	docker build . --force-rm --compress --file docker/swoole/Dockerfile --tag ${REGISTRY}/swoole:${VERSION}


.PHONY: docker-push
docker-push:
	docker push ${REGISTRY}/cli:${VERSION}
	docker push ${REGISTRY}/fpm_server:${VERSION}
	docker push ${REGISTRY}/web_server:${VERSION}
