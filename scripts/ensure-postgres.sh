#!/usr/bin/env bash
set -euo pipefail

if pg_isready -q; then
    echo "PostgreSQL is already running."
    exit 0
fi

echo "PostgreSQL is not running — starting it..."
sudo service postgresql start

for _ in {1..10}; do
    if pg_isready -q; then
        echo "PostgreSQL is up."
        exit 0
    fi
    sleep 0.5
done

echo "PostgreSQL did not become ready after starting. Check 'sudo service postgresql status'." >&2
exit 1
