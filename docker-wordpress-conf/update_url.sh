#!/bin/bash
url=$1
printf "\n changing url to $url \n"
wp option update siteurl $url --allow-root
wp option update home $url --allow-root