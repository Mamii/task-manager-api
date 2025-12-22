#!/bin/bash
set -e

echo "🚀 Starting entrypoint.sh"
echo "ENV CHECK → DB_HOST=$DB_HOST DB_USERNAME=$DB_USERNAME"

echo "🔧 Fixing permissions on storage & cache..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "⏳ Waiting for MySQL..."
until mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --ssl=false --silent; do
  echo "⚙️  Still waiting for MySQL ($DB_HOST)..."
  sleep 2
done

echo "✅ MySQL is up. Now running migrations..."
su -s /bin/bash www-data -c "php artisan migrate --force" || {
  echo "❌ Migration failed";
  exit 1;
}

echo "🚀 Starting PHP-FPM..."
exec php-fpm
