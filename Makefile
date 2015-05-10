all: test

test:
	php vendor/bin/phpunit tests

api:
	apigen generate --source src --destination api

pages: api
	mv api api.bak
	git checkout gh-pages
	rm -rf api
	mv api.bak api
