# Variables
APP_CONTAINER=app

# ------------------------------
# Première installation
# ------------------------------
setup: build install key migrate seed
	@echo "Project ready at http://localhost:8080"

build:
	@echo "Building containers..."
	docker compose up -d --build

install:
	@echo "Installing Composer dependencies..."
	docker exec -it $(APP_CONTAINER) composer install

key:
	@echo "Generating app key..."
	docker exec -it $(APP_CONTAINER) php artisan key:generate

migrate:
	@echo "Running migrations..."
	docker exec -it $(APP_CONTAINER) php artisan migrate --force

seed:
	@echo "Seeding database..."
	docker exec -it $(APP_CONTAINER) php artisan db:seed

# ------------------------------
# Mise à jour du projet
# ------------------------------
update:
	@echo "Pulling updates & refreshing migrations..."
	git pull
	docker compose up -d
	docker exec -it $(APP_CONTAINER) php artisan migrate --force
	@echo "✅ Project updated!"

# ------------------------------
# Maintenance
# ------------------------------
fresh:
	@echo "Dropping and reseeding database..."
	docker exec -it $(APP_CONTAINER) php artisan migrate:fresh --seed

logs:
	docker compose logs -f app

bash:
	docker exec -it $(APP_CONTAINER) bash

up:
	docker compose up -d

down:
	docker compose down

down-v:
	docker compose down -v

rebuild:
	docker compose down -v
	docker compose up -d --build

# ------------------------------
# Help
# ------------------------------
help:
	@echo ""
	@echo "Usage:"
	@echo "  make setup       - Build containers, install, migrate & seed"
	@echo "  make update      - Pull latest code & run migrations"
	@echo "  make fresh       - Recreate DB from scratch (local only!)"
	@echo "  make bash        - Enter Laravel container"
	@echo "  make logs        - Tail Laravel container logs"
	@echo "  make down        - Stop containers"
	@echo "  make rebuild     - Rebuild containers and reset DB"
	@echo ""

.PHONY: setup build install key migrate seed update fresh logs bash up down down-v rebuild help
