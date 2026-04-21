#!/usr/bin/env bash
# Script de build para Render — Laravel
# Se ejecuta cada vez que se hace deploy

# Instalar dependencias de Composer (sin paquetes de desarrollo)
composer install --no-dev --optimize-autoloader

# Cachear configuración para más velocidad
php artisan config:cache
php artisan route:cache

# Ejecutar migraciones (crear tablas si no existen)
php artisan migrate --force

# Sembrar la BD con datos de ejemplo (los 3 entrenadores + Pokémon)
php artisan db:seed --force