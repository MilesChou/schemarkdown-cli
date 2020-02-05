#!/usr/bin/make -f

PHP_MAJOR_VERSION := $(shell php -r "echo PHP_MAJOR_VERSION;")

.PHONY: all clean clean-all check test analyse coverage container sqlite

# ---------------------------------------------------------------------

all: test analyse

clean:
	rm -rf ./build
	rm -f docusema.phar

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

docusema.phar:
	@echo ">>> Building phar ..."
	@composer install --no-dev --optimize-autoloader --quiet
	@./scripts/bump-version bump ${VERSION}
	@php -d phar.readonly=off ./scripts/build
	@chmod +x docusema.phar
	@echo ">>> Build phar finished."
	@composer install --dev --quiet

sqlite:
	@sqlite3 tests/Fixtures/sqlite.db < tests/Fixtures/sqlite.sql
