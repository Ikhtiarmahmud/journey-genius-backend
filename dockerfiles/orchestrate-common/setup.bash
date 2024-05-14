#!/bin/bash

################ Check if .env and docker-compose yml file ################
# Check if .env file exist or not; if not: exit
[[ -f .env ]] || { echo >&2 "Create .env file from .env.example"; exit 1; }

# Create docker-compose file from example
if [ ! -f docker-compose.yml ]; then
  cp docker-compose.yml.example docker-compose.yml;
  echo "docker-compose.yml file created";
fi


################ Read .env file values ################
set -o allexport
source .env
set +o allexport

BASE_DIRECTORY="${PWD}/.."
ORCHESTRATE_DIRECTORY="${BASE_DIRECTORY}/orchestrate-common"
LOCALHOST="http://localhost"
HOST_IP=""

HOST_IP=`ip -4 addr show docker0 | grep -oP '(?<=inet\s)\d+(\.\d+){3}'`

if [ $? -ne 0 ]; then
    # If docker host ip not found (in case of mac or windows)
      if [ -z "$HOST_IP"]; then
        HOST_IP=`ifconfig | grep "1[97]2.*" -m 1 | cut -d' ' -f 2 | xargs`
      fi
fi

ImportSql() {
  echo "Running the script..."
  echo "Creating MySQL Database: $3 into the container: $1"
  eval "${DOCKER_COMPOSE} exec -T $1 mysql -uroot -p${MYSQL_DB_PASSWORD} -e \"DROP DATABASE IF EXISTS $3; CREATE DATABASE IF NOT EXISTS $3\""
  echo "Importing the $2 into the database: $2"
  eval "${DOCKER_COMPOSE} exec -T $1 mysql -uroot -p${MYSQL_DB_PASSWORD} $3 < $2"
}

CreateVolumes() {
  echo "Creating volumes... "
  eval "mkdir -p ${REDIS_PATH}"
  eval "mkdir -p ${MYSQL_PATH}"
  eval "mkdir -p ${MONGO_PATH}"
  eval "mkdir -p ${RMQ_PATH}"
  wait
}

BuildImages() {
  echo "Building up the docker images..."
  eval "${DOCKER_COMPOSE} build"
}

################ Build docker containers ################
BuildContainers() {
  CreateVolumes
  echo "Bring up the docker containers"
  eval "${DOCKER_COMPOSE} up -d --remove-orphans"

  #  sleep 3
  wait

  echo "Running: docker kill $(${DOCKER_COMPOSE} ps -aq)"
  eval "docker kill $(${DOCKER_COMPOSE} ps -aq)"
  eval "${DOCKER_COMPOSE} up -d"
}


clear

while test $# -gt 0; do
  case "$1" in
    -build)
      shift
      # move to orchestrate directory
      cd ${ORCHESTRATE_DIRECTORY}
      echo "Starting docker build"
      BuildContainers
      shift
      ;;
    -build-container)
      shift
      CreateVolumes
      # move to orchestrate directory
      cd ${ORCHESTRATE_DIRECTORY}
      echo "Starting docker build..."
      echo "Bring up the docker containers..."
      eval "${DOCKER_COMPOSE} up -d --remove-orphans"
        #  sleep 3
      wait
      
      echo "Running: docker kill $(${DOCKER_COMPOSE} ps -aq)"
      eval "docker kill $(${DOCKER_COMPOSE} ps -aq)"
      eval "${DOCKER_COMPOSE} up -d"
      shift
      ;;
    -build-image)
      shift
      # move to orchestrate directory
      cd ${ORCHESTRATE_DIRECTORY}
      echo "Starting docker build images"
      BuildImages
      shift
      ;;
    -import-sql)
      shift
      echo "the format of the command: ./setup.bash -import-sql \"mysql8 ~/Downloads/seed-data.sql bl_cms_db\""
      # move to orchestrate directory
      cd ${ORCHESTRATE_DIRECTORY}
      ImportSql $1 $2 $3
      echo "Task is finished!"
      shift
      ;;
    *)
      shift
      echo "You have added an un-recognized flag!"
      shift
      ;;
  esac
 done