#!/bin/bash
set -e

echo "Memulai deployment..."

# Ambil kode terbaru dari GitLab
echo "Menjalankan git pull..."
git pull origin develop

# Bangun dan jalankan container
echo "Membangun dan memulai Docker containers..."
docker-compose down
docker-compose up -d --build

# Tunggu database siap
echo "Menunggu database..."
sleep 20

# Jalankan migrasi dan cache di dalam container
echo "Menjalankan database migrations..."
docker-compose exec -T app php artisan migrate --force

echo "Caching configuration..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Bersihkan image lama
echo "Membersihkan Docker images lama..."
docker image prune -f

echo "Deployment selesai!"