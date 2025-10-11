#!/bin/bash
set -e

# Esperar a que MySQL esté listo
echo "Esperando MySQL..."
until php artisan migrate --force 2>/dev/null; do
  echo "MySQL no está listo - esperando..."
  sleep 2
done

echo "MySQL listo! Ejecutando migraciones..."
php artisan migrate --force

echo "Iniciando Apache..."
exec apache2-foreground