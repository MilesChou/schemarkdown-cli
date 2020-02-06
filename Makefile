#!/usr/bin/make -f

PHP_MAJOR_VERSION := $(shell php -r "echo PHP_MAJOR_VERSION;")

.PHONY: all clean clean-all check test analyse coverage container sqlite examples

# ---------------------------------------------------------------------

all: test analyse

clean:
	rm -rf ./build
	rm -f schemarkdown.phar

clean-all: clean
	rm -rf ./vendor
	rm -rf ./composer.lock

check:
	php vendor/bin/phpcs

test: clean check
	phpdbg -qrr vendor/bin/phpunit

analyse:
	php vendor/bin/phpstan analyse src --level=5

coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi

container:
	@docker-compose down -v
	@docker-compose up -d
	@docker-compose logs -f

schemarkdown.phar:
	@echo ">>> Building phar ..."
	@composer install --no-dev --optimize-autoloader --quiet
	@./scripts/bump-version ${VERSION}
	@php -d phar.readonly=off ./scripts/build
	@chmod +x schemarkdown.phar
	@echo ">>> Build phar finished."
	@composer install --dev --quiet

sqlite:
	@sqlite3 tests/Fixtures/sqlite.db < tests/Fixtures/sqlite.sql

examples:
	php bin/schemarkdown.php --config-file=tests/Fixtures/database.php --output-dir=examples
