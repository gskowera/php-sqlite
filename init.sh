#!/bin/sh
set -e

/usr/bin/sqlite3 /sqlite/app.sqlite "CREATE TABLE IF NOT EXISTS addresses (id INTEGER PRIMARY KEY,firstname TEXT,lastname TEXT,mobile TEXT,email TEXT,address TEXT);"

exec /usr/sbin/apache2ctl -D FOREGROUND