#!/bin/bash
set -e # Exit immediately if a command exits with a non-zero status.

echo "Starting deployment..."

# Navigate to the project directory
cd $PROJECT_PATH

# Create the .env file from GitLab's CI/CD variables
# This is a secure way to handle credentials
echo "Creating .env file..."
echo "APP_NAME=Laravel" > .env
echo "APP_ENV=production" >> .env
echo "APP_KEY=${APP_KEY}" >> .env
echo "APP_DEBUG=false" >> .env
echo "APP_URL=http://10.11.0.20" >> .env

echo "LOG_CHANNEL=stack" >> .env

echo "DB_CONNECTION=mysql" >> .env
echo "DB_HOST=db" >> .env
echo "DB_PORT=3306" >> .env
echo "DB_DATABASE=${DB_DATABASE}" >> .env
echo "DB_USERNAME=${DB_USERNAME}" >> .env
echo "DB_PASSWORD=${DB_PASSWORD}" >> .env

echo "BROADCAST_DRIVER=log" >> .env
echo "CACHE_DRIVER=file" >> .env
echo "QUEUE_CONNECTION=sync" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "SESSION_LIFETIME=120" >> .env

# Pull the latest changes from the repository
echo "Pulling latest code..."
git pull origin main # Or master

# Stop and remove old containers, and rebuild new ones
echo "Building and starting Docker containers..."
docker-compose down
docker-compose up -d --build

# Wait for the database container to be ready
echo "Waiting for database..."
sleep 20

# Run Laravel commands inside the new 'app' container
echo "Running database migrations..."
docker-compose exec -T app php artisan migrate --force

echo "Caching configuration..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

# Clean up unused Docker images
echo "Cleaning up old Docker images..."
docker image prune -f

echo "Deployment finished successfully!"