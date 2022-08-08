default: lint


.PHONY: lint-php
lint-php:
	vendor/bin/phplint --configuration=.phplint.yml --ansi

.PHONY: lint-phpcs
lint-phpcs:
	vendor/bin/phpcs --standard=PSR12 src

.PHONY: lint-phpcs-fixer
lint-phpcs-fixer:
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --dry-run --verbose --ansi

.PHONY: lint
lint:
	make --no-print-directory lint-php && \
	make --no-print-directory lint-phpcs && \
	make --no-print-directory lint-phpcs-fixer


.PHONY: fix-phpcbf
fix-phpcbf:
	vendor/bin/phpcbf --standard=PSR12 src

.PHONY: fix-phpcs-fixer
fix-phpcs-fixer:
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --verbose --ansi

.PHONY: fix
fix:
	make --no-print-directory fix-phpcbf && \
	make --no-print-directory fix-phpcs-fixer


.PHONY: qa-phpcpd
qa-phpcpd:
	vendor/bin/phpcpd src

.PHONY: qa-phpmd
qa-phpmd:
	vendor/bin/phpmd src ansi unusedcode,naming,design,controversial,codesize

.PHONY: qa-phpmnd
qa-phpmnd:
	vendor/bin/phpmnd --ansi src

.PHONY: qa-compatibility
qa-compatibility:
	vendor/bin/phpcs --standard=PHPCompatibility --runtime-set testVersion 8.1- src

.PHONY: qa-phpstan
qa-phpstan:
	vendor/bin/phpstan analyse --memory-limit=2G --no-progress

.PHONY: qa
qa:
	make --no-print-directory qa-phpcpd && \
	make --no-print-directory qa-phpmd && \
	make --no-print-directory qa-phpmnd && \
	make --no-print-directory qa-compatibility && \
	make --no-print-directory qa-phpstan
