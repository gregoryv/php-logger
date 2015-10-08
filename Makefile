all: test

test:
	php vendor/bin/phpunit tests

coverage:
	./vendor/bin/phpunit --coverage-html build/logs/coverage/ --coverage-clover build/logs/clover.xml tests

api:
	apigen generate --source src --destination api

pages: api
	mv api api.bak
	git checkout gh-pages
	rm -rf api
	mv api.bak api
