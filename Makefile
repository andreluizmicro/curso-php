CONTAINER_NAME=app
COMPOSEV2 := $(shell docker compose version)

ifdef COMPOSEV2
    COMMAND=docker compose
else
    COMMAND=docker-compose
endif

docker-build:
	$(COMMAND) build

docker-up:
	$(COMMAND) up -d

docker-down:
	$(COMMAND) down

docker-bash:
	$(COMMAND) exec $(CONTAINER_NAME) bash

docker-check: docker-up
	$(COMMAND) run --rm $(CONTAINER_NAME) composer check

docker-test:
	 $(COMMAND) run --rm $(CONTAINER_NAME) composer test
