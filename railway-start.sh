#!/bin/bash
# Railway start script — auto migrate + seed on first deploy, then start server

set -e

# Ensure required directories exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p bootstrap/cache

chmod -R 775 storage bootstrap/cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed only if users table is empty (first deploy)
echo "Checking if seed is needed..."
php artisan db:seed --force --class=DatabaseSeeder 2>/dev/null || true

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
