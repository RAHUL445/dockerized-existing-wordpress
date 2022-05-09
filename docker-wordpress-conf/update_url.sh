#!/bin/bash
url=$1
if [ -z "$1" ] ; then
  printf "\n example:  update_url http://localhost:8080  \n"
  exit 0
fi
printf "\n changing url to $url \n"
wp option update siteurl $url --allow-root
wp option update home $url --allow-root