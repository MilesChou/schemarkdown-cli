#!/usr/bin/make -f

INSTALL_PATH := /usr/local/bin/schemarkdown

.PHONY: all clean clean-all check test coverage container bump sqlite examples

# ---------------------------------------------------------------------

all: clean test schemarkdown.phar

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

coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi

container:
	@docker-compose down -v
	@docker-compose up -d
	@docker-compose logs -f

bump:
	@./scripts/bump-version ${VERSION}

schemarkdown.phar: bump
	@echo ">>> Building phar ..."
	@box compile

sqlite:
	@sqlite3 tests/Fixtures/sqlite.db < tests/Fixtures/sqlite.sql

examples:
	php bin/schemarkdown.php --config-file=tests/Fixtures/database.php --output-dir=examples

install:
	mv schemarkdown.phar ${INSTALL_PATH}
