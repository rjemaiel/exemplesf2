#!/bin/sh
php app/console assets:install web
php app/console cache:clear
php app/console cache:clear --env=prod
