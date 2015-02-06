SHELL := /bin/bash

all: init doc

init: install-composer install

install-composer:
	if [ ! -e composer.phar ]; then curl -sS https://getcomposer.org/installer | php; fi

install: install-composer
	php composer.phar install

update:	install-composer
	php composer.phar self-update
	php composer.phar update

doc: install
	vendor/bin/apigen generate --source="src" --destination="doc/api"

test: FORCE
	vendor/bin/phpunit --bootstrap vendor/autoload.php test

clean:
	rm -rf doc vendor composer.phar

FORCE:
