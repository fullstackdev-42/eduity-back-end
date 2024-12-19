#!/bin/bash
# Filename: bin/copytocontainer
[ -z "$1" ] && echo "Please specify a directory or file to copy to container (ex. vendor, all)" && exit

if [ "$1" == "all" ]; then
  docker cp application/./ $(docker-compose ps|grep php-fpm|awk '{print $1}'):/var/www/html/
  echo "Completed copying all files from host to container"
else
  docker cp application/$1 $(docker-compose ps|grep php-fpm|awk '{print $1}'):/var/www/html/
  echo "Completed copying $1 from host to container"
fi