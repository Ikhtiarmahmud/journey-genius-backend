#!/bin/bash

DOCKER_COMPOSE="docker compose"

DatabaseSeed(){
    OUTPUT=$(${DOCKER_COMPOSE} exec $1 php artisan db:seed)
    echo "${1^}: ${OUTPUT}"
}

SERVICES="bl_cms_api"

for SERVICE in ${SERVICES}
do
    DatabaseSeed ${SERVICE}
done