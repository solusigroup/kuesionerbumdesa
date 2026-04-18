#!/bin/bash
set -e

echo "🚀 Starting Deployment..."

# Put application in maintenance mode
(php artisan down) || echo "Application already down"

# Pull the latest changes from the git repository
# Ensure we are using the main branch
git pull origin main

# Note: In shared hosting, composer might not be available or have memory limits.
# If it's available, we attempt to optimize dependencies.
if command -v composer &> /dev/null
then
    echo "📦 Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
else
    echo "⚠️ Composer not found, skipping installation (Ensure vendor folder is uploaded/synced)"
fi

# Run database migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Clear and Cache Config/Routes/Compiler
echo "⚡ Optimizing application..."
php artisan optimize
php artisan view:cache

# Bring application out of maintenance mode
php artisan up

echo "✅ AI Deployment Successful!"
