SHELL := /bin/bash

all: init doc

init: install-composer depends-install

install-composer: composer.phar

depends-install: install-composer
	php composer.phar install

depends-update: install-composer
	php composer.phar self-update
	php composer.phar update

doc: depends-install
	vendor/bin/apigen generate --source="src" --destination="doc/api"

test:
	vendor/bin/phpunit --bootstrap vendor/autoload.php test

clean:
	rm -rf doc vendor composer.phar

composer.phar:
	curl -sS https://getcomposer.org/installer | php

.PHONY: all init install-composer depends-install depends-update doc test clean
