#!/bin/bash
username=root
password=root
contains=$(mysql -u${username} -p${password}  -e "SELECT SCHEMA_NAME   FROM INFORMATION_SCHEMA.SCHEMATA  WHERE SCHEMA_NAME = 'wordpress_db';")
if [[ "$contains" == *"wordpress_db"* ]] ; then
  printf "\n DATABASE is already present\n"
  exit
fi
printf "\n creating database and importing database"
mysql -u${username} -p${password}  -e "CREATE DATABASE wordpress_db"

mysql -u${username} -p${password}  wordpress_db < /home/wp-database/wordpress_db.sql

mysql -u${username} -p${password}  -e "SELECT SCHEMA_NAME   FROM INFORMATION_SCHEMA.SCHEMATA  WHERE SCHEMA_NAME = '%wordpress_db%';"