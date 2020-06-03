.PHONY: tests
tests: phpunit phpcs-check phpstan ## Run tests suite

.PHONY: init
init: ## Init git after clone
	rm -Rf .git
	git init
	composer --ignore-platform-reqs install

.PHONY: bench
bench: ## Run benchmarks
	vendor/bin/phpbench run --report='generator: "table", break: ["benchmark", "revs"], cols: ["subject", "mean", "best"]' --bootstrap='vendor/autoload.php' benchmarks

.PHONY: phpunit
phpunit: ## Launch PHPUnit test suite
	vendor/bin/phpunit --colors=always --coverage-html .coverage -c phpunit.xml

.PHONY: phpcs
phpcs: ## Apply PHP CS fixes
	vendor/bin/php-cs-fixer fix

.PHONY: phpcs-check
phpcs-check: ## Coding style checks
	vendor/bin/php-cs-fixer fix --dry-run

.PHONY: phpstan
phpstan: ## Static analysis
	vendor/bin/phpstan analyse --level=1 src

.PHONY: help
help: ## Display this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
