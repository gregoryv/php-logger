all: test

test:
	php vendor/bin/phpunit tests

pages:
	apigen generate --source src --destination api

