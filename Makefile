all: test

test:
	php vendor/bin/phpunit tests

pages:
	apigen generate --source src --destination api
	mv api api.bak
	git checkout gh-pages
	rm -rf api
	mv api.bak api
