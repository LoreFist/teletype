#!/bin/sh

composer install --no-interaction
php yii migrate/up --interactive=0