#!/bin/bash
# Filename: bin/copyfromcontainer
[ -z "$1" ] && echo "Please specify a directory or file to copy from container (ex. vendor, all)" && exit

if [ "$1" == "all" ]; then
  docker cp $(docker-compose ps|grep php-fpm|awk '{print $1}'):/var/www/html/./ application/
  echo "Completed copying all files from container to host"
else
  docker cp $(docker-compose ps|grep php-fpm|awk '{print $1}'):/var/www/html/$1 application/
  echo "Completed copying $1 from container to host"
fi