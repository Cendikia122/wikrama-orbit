#!/bin/bash
# Railway start script — runs migrations + seed on first deploy, then starts server

# Ensure storage & cache dirs exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Create SQLite database if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    echo "SQLite database created."
fi

# Run migrations
php artisan migrate --force

# Seed only if users table is empty (first deploy)
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

# Clear & rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
