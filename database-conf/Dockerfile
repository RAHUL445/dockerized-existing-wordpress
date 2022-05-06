FROM mysql:5.7

LABEL maintainer="rahul.pandey"
LABEL wp_db="mysql"

RUN mkdir -p /home/wp-database
COPY ./database-conf /home/wp-database

WORKDIR /home/wp-database/
RUN chmod 777 setup_database_in_docker.sh && cp setup_database_in_docker.sh /usr/bin/setup_database_in_docker
