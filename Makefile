cs:
	vendor/bin/php-cs-fixer fix src

integration:
	vendor/bin/phpunit --configuration=test/Integration/phpunit.xml