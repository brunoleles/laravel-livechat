#! /bin/bash
cd "$(dirname "$0")/../"

docker-compose exec --user app web php /var/www/html/artisan le:chat-server
