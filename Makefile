de := docker exec -it 
sy := $(de) php symfony console

up:
	docker compose up -d --build

enter:
	$(de) php /bin/sh

down:
	docker compose down --remove-orphans

reset: 
	$(sy) doctrine:database:drop --force -q
	$(sy) doctrine:database:create -q
	$(sy) doctrine:migrations:migrate -q
	$(sy) doctrine:schema:validate -q
	$(sy) doctrine:fixtures:load -q

install:
	docker compose up -d --build
	$(de) php composer update -n
	$(sy) doctrine:migrations:migrate -q
	$(sy) doctrine:schema:validate -q
	$(sy) doctrine:fixtures:load -q

	
	