#!/bin/bash

DOCKER_COMPOSE="docker compose"

ClearConfig(){
    OUTPUT=$(${DOCKER_COMPOSE} exec $1 php artisan config:clear)
    echo "${1^}: ${OUTPUT}"
}

SERVICES="bl_cms_api"

for SERVICE in ${SERVICES}
do
    ClearConfig ${SERVICE}
done