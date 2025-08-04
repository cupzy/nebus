.PHONY: setup test pre-commit

setup:
	docker compose up -d --build
	docker compose exec app composer install --no-scripts
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		docker compose exec app ./artisan key:generate; \
	fi
	docker compose exec app ./artisan migrate --seed
	docker compose exec postgres bash -c \
      'psql -U root -d postgres -tc "SELECT 1 FROM pg_database WHERE datname = '\''testing'\''" | grep -q 1 || psql -U root -d postgres -c "CREATE DATABASE testing"'

test:
	docker compose exec app ./artisan test

pre-commit:
	docker compose exec app ./vendor/bin/pint
	make test
