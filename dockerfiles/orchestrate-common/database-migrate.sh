#!/bin/bash

DOCKER_COMPOSE="docker compose"

DatabaseMigrate(){
    OUTPUT=$(${DOCKER_COMPOSE} exec $1 php artisan migrate)
    echo "${1^}: ${OUTPUT}"
}

SERVICES="bl_cms_api"

for SERVICE in ${SERVICES}
do
    DatabaseMigrate ${SERVICE}
done