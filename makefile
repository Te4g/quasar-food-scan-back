.SILENT:

cs: ## Run php cs fixer
	php-cs-fixer fix src tests --dry-run --stop-on-violation --diff

cs-fix: ## Run php cs fixer and fix errors
	php-cs-fixer fix src tests

phpunit: ## Run PHPUnit
	./bin/phpunit

stan: ## Run php stan
	vendor/bin/phpstan analyse src tests --level 5

.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help