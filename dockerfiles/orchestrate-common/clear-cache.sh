#!/bin/bash

DOCKER_COMPOSE="docker compose"

ClearCache(){
    OUTPUT=$(${DOCKER_COMPOSE} exec $1 php artisan cache:clear)
    echo "${1^}: ${OUTPUT}"
}

SERVICES="bl_cms_api"

for SERVICE in ${SERVICES}
do
    ClearCache ${SERVICE}
done