#!/bin/bash

# LadyLingua Production Deployment Script
# Run this script when switching to production environment

echo "🚀 Deploying LadyLingua to Production..."

# Set production environment
echo "📝 Setting production environment..."
export APP_ENV=production
export APP_DEBUG=false

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Install/update composer dependencies for production
echo "📦 Installing production dependencies..."
composer install --optimize-autoloader --no-dev

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Create cache table if it doesn't exist
echo "📋 Setting up cache table..."
php artisan cache:table 2>/dev/null || echo "Cache table already exists"

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create admin user
echo "👤 Setting up admin user..."
php artisan test:admin-access --create

# Set proper permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Production deployment complete!"
echo ""
echo "📋 Production Checklist:"
echo "1. Update .env file with production settings"
echo "2. Set APP_ENV=production"
echo "3. Set APP_DEBUG=false"
echo "4. Update APP_URL to your domain"
echo "5. Configure proper SESSION_SECURE_COOKIE=true for HTTPS"
echo "6. Test admin login at /platform/login"
echo ""
echo "🔗 Admin Panel: /platform"
echo "👤 Admin Email: admin@ladylingo.uz"
echo "🔑 Default Password: admin123"
