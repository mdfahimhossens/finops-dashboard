#!/usr/bin/env bash
set -e

echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "Running migrations..."
php artisan migrate --force

echo "Linking storage (optional)..."
php artisan storage:link || true

echo "Starting Apache..."
apache2-foreground
