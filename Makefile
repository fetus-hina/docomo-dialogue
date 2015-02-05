SHELL := /bin/bash

all: init doc

init: install-composer install

install-composer:
	if [ -e composer.phar ]; then \
		php composer.phar self-update; \
	else \
		curl -sS https://getcomposer.org/installer | php; \
	fi

install: install-composer
	php composer.phar install

update:	install-composer
	php composer.phar update

doc: install
	vendor/phpdocumentor/phpdocumentor/bin/phpdoc -p -d ./src -t ./doc/api

clean:
	rm -rf doc vendor composer.phar
