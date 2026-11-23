#!/bin/sh
set -eu

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Running Laravel database migrations..."
    php /app/deploy-migrate.php
fi

exec frankenphp run --config /etc/caddy/Caddyfile
