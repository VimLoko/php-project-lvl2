install:
	composer install --ignore-platform-reqs
validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
test:
	composer exec --verbose phpunit tests
test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml