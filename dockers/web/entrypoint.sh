#!/bin/bash

if [[ -z "$SERVERS" || "$SERVERS" =~ ^(both|apache)$ ]]; then
    /usr/sbin/apache2ctl -D FOREGROUND &
fi

if [[ -z "$SERVERS" || "$SERVERS" =~ ^(both|chatserver)$ ]]; then
    php artisan le:chat-server &
fi

wait -n

exit $?


