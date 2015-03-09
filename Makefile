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
	vendor/bin/phpunit

check-style:
	vendor/bin/phpmd src text codesize,design,naming,unusedcode
	vendor/bin/phpcs --standard=PSR2 src test

fix-style:
	vendor/bin/phpcbf --standard=PSR2 src test

clean:
	rm -rf doc vendor composer.phar

composer.phar:
	curl -sS https://getcomposer.org/installer | php

.PHONY: all init install-composer depends-install depends-update doc test clean
