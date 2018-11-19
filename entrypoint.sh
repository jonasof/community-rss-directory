#!/bin/bash
set -e

cat /etc/passwd

file_meta=($(ls -lnd /app/Dockerfile))

export USER_ID="${file_meta[2]}"
export GROUP_ID="${file_meta[3]}"

usermod -u "${USER_ID}" www-data
chown -R www-data /etc/apache2

touch /app/database/database.sqlite

exec docker-php-entrypoint "$@"