# Dockerized Existing Wordpress Code

## Prerequisites
1. Docker and Docker Compose [installation steps](!https://docs.docker.com/compose/install/)
1. existing wordpress code and database in .sql format

## Step to Start (one time/changing to your wp code & database)
1. move your wordpress code to the wordpress-code folder
1. move your existing wordpress database to database-conf folder with name 'wordpress_db.sql'

```shell
cd dockerized-existing-wordpress
rm -rf wordpress-code   # remove old wordpress-code
cp -r existing_worpress_code wordpress-code 
cp docker-wordpress-conf/wordpress.docker.php wordpress-code/
cp existing_db.sql database-conf/wordpress_db.sql
```
1. change existing_wordpress_code with your wordpress code
1. change existing_db.sql with your database
1. if you don't have code and database use current wordpress code and database
1. basic configuration is done

## Build Docker Image and Start Container for Settings

```shell
cd dockerized-existing-wordpress
docker-compose build --no-cache # build image
docker-compose up -d  # start container for one time setting
docker ps # to list running containers
# setting to be done, upload existing db(wordpress_db.sql) to the mysql server
docker exec -it [container_name/id of mysql docker] setup_database_in_docker
# setting wordpress domain name in siteurl and home in wp_options
docker exec -it [container_name/id of wp docker] update_url http://localhost:8080
# 8080 is default port for wordpress docker, change in docker-compose if you want
docker-compose down # stop the container
```
1. All the configuration are done

## Active Development
```shell
cd dockerized-existing-wordpress
docker-compose up -d # to start the docker service
docker-compose down # to stop the services
```


## Other Details
1. wordpress-code volumes is mount to wp docker (host volume) /var/www/html/wordpress-code folder
1. so whatever changes you do in the wordpress-code in the host. will reflect in the wp docker
1. mysql server data is persistent means your changes are saved. we're using wordpress_volume_db (named volume) 


## More to Know
1. wp docker is using wp-config.docker.php file as wp-config.php file. coping wp-config.docker.php to wp-config.php
```shell
docker network ls 
docker network inspect [network_name] # to see network info
docker volume ls
docker volume inspect [volume_name] # to see details
```