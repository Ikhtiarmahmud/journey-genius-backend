## **What is the purpose of this repo:**

- We prefer to use this repo ___(with a single script)___ to up and running all the common services
- Currently available services as listed below -

         1. MySQL 8
         2. Redis
         3. MongoDB
         4. PhpMyAdmin
         5. RabbitMQ

- Can be added more and more later

## **How to run this Orchestrate Common Repo?**

**Basic Requirements:**

- [ ] You must have Docker & Compose and their related commands available in the system
- [ ] You should have some sort of bash command available, i.e. `chmod` to run the bash script
- [ ] You should run the script once basically for the first time successful build
- [ ] ___After the containers started successfully with this script, you should not run the script again___

**Permission denied error for **`docker compose`** command:**

- Manually put the correct one for the variable __`DOCKER_COMPOSE`__ either `docker compose ` or `docker-compose ` in line 31 and comment out from line 43 to 54 in `./setup.bash` file.

```sh
31      DOCKER_COMPOSE="docker compose "
or
31      DOCKER_COMPOSE="docker-compose "
```

**Starting Method 1:**

_Step 1: Clone this repo: "orchestrate-common"_

```sh
mkdir -p ${HOME}/CommonServices
cd ${HOME}/CommonServices

git clone git@bitbucket.org:digital-platforms/orchestrate-common.git
```

```sh
Or with https as below:
```

```sh
git clone https://nhsarkar@bitbucket.org/digital-platforms/orchestrate-common.git
```

_Step 2: Create .env and make necessary changes_

- i.e. ports and api and paths (if required)

```sh
cd ./orchestrate-common
cp .env.example .env
```

_Step 3: Make the bash file executable_

```sh
chmod +x setup.bash
```

_Step 4: RUN the below command_

```sh
./setup.bash -build 
```

**Starting Method 2:**

- You can manually run the `docker compose`

_Step 1: Follow the Method 1 up to step 2_

- i.e. cloning the repo and make changes to the env

_Step 2: Run the `docker compose` command_

```sh
docker compose up -d

or 

docker-compose up -d
```

> ___You should see the `containers started` status___

> _From now on, you should use __`docker compose`__ commands to up or down any service instead of running again  __`./setup.bash -build`__ script_

## **Common Links:**

1. PMA: `http://localhost:8080/PhpMyAdmin`
2. MongoDB: `...`

## **For MySQL:**

**How to import a example.sql to mysql8 container**

**Method 1 - Use Script Import Sql Command:**

_Step 1 - Run just one command as below:_

Format:

```sh
./setup.bash -import-sql "container-name path/of/the/seed-data.sql database-name"
```

Real Example:

```sh
./setup.bash -import-sql "mysql8 ~/Downloads/seed-data.sql bl_cms_db"
```

**Method 2 - Manually Procedure:**

- Access the mysql8 container
- Create database and Import

_Step 1: Copy the sql into mysql8 container root_

```sh
cd /path/to/folder/sql

docker cp ./example.sql mysql8:/

```

_Step 2: Access to the mysql8 container_

```sh
docker exec -it mysql8 bin/bash
```

_Step 3: Access to the mysql database_

```sh
mysql -u root -p
(Enter MySQL Password)
```

_Step 4: Create or Select the desired database and import_

- Check if there is already a database `bl_cms_db` created

```sh
show databases;
```

- You should see as below with database `bl_cms_db`

```sh
mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| bl_cms_db          |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)
```

- If you don't see the database `bl_cms_db`, create it

```sh
create database bl_cms_db;

use bl_cms_db;
```

_Step 5: Finally import the sql_

```sh
source ./example.sql;
```

> Tada!

