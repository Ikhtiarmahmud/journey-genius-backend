#!/bin/bash

DOCKER_COMPOSE="docker compose"

ClearRoute(){
    OUTPUT=$(${DOCKER_COMPOSE} exec $1 php artisan route:clear)
    echo "${1^}: ${OUTPUT}"
}

SERVICES="bl_cms_api"

for SERVICE in ${SERVICES}
do
    ClearRoute ${SERVICE}
done