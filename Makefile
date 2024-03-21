up:
	docker-compose up -d
build:
	docker-compose build
stop:
	docker-compose stop
rm:
	docker-compose down
shell:
	docker exec -it php82-container bash
composer-install:
	docker exec php82-container composer install
test:
	docker exec php82-container php bin/phpunit
cache:
	docker exec php82-container php bin/console cache:clear
diff:
	docker exec php82-container php bin/console doctrine:migration:diff
migrate:
	docker exec php82-container php bin/console doctrine:migration:migrate