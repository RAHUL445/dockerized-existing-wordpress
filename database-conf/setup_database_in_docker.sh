#!/bin/bash
username=root
password=root
db_name=wordpress_db

# function to check is db exist
db_exist() {
  contains=$(mysql -u${username} -p${password}  -e "SELECT SCHEMA_NAME   FROM INFORMATION_SCHEMA.SCHEMATA  WHERE SCHEMA_NAME = '${db_name}';")
  if [[ "$contains" == *"${db_name}"* ]] ; then
    return 1  # true
  fi
  return 0  # false
}

check_db_present(){
  db_exist
  if [ "$?" = "1" ] ; then
    printf "\n DB Is Already Present \n"
    exit
  fi
}

check_db_not_present() {
  db_exist
  if [ "$?"  = "0" ] ; then
    printf "\n DB Is Not Present \n"
    exit
  fi
}


if [ "$1" = "create_db" ] ; then
  check_db_present
  printf "\n creating database db_name: ${db_name} \n"
  echo "CREATE DATABASE ${db_name}"
  mysql -u${username} -p${password}  -e "CREATE DATABASE ${db_name} ;"
elif [ "$1" = "import_db" ]; then
  check_db_not_present
  printf "\n importing database ${db_name} from $(pwd) folder \n"
  mysql -u${username} -p${password}  ${db_name} < /home/wp-database/${db_name}.sql
elif [ "$1" = "export_db" ]; then
  check_db_not_present
  printf "\n exporting database ${db_name} to location in docker ${PWD} File: ${db_name}_$(date +%F_%H-%M-%S).sql \n"
  mysqldump -u${username} -p${password}  ${db_name} > ${db_name}_$(date +%F_%H-%M-%S).sql
elif [ "$1" = "drop_db" ]; then
  check_db_not_present
  printf "\n dropping database ${db_name} \n"
  mysql -u${username} -p${password}  -e "DROP DATABASE ${db_name} ;"
else
  printf "\n 1. create_db \n 2. import_db \n 3. export_db \n 4. drop_db \n"
fi

