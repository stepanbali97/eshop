bash-3.2$ ./docker ps --no-trunc
CONTAINER ID                                                       IMAGE                                                                     COMMAND                                          CREATED      STATUS        PORTS                                      NAMES
8d4821116483209bec7b9742660117dedfd2c328f885a2da5f5cd881a9251af4   sha256:8e4b9561681f6451fb2b1ece4c7b962086ad71e9a98de65c8f4695c3896c96bd   "docker-php-entrypoint php-fpm"                  5 days ago   Up 26 hours   0.0.0.0:9000->9000/tcp                     php
d00d8cdc77909d780e5becaf52542f66faa7ee0b8a63191d7b644b061e6c951c   nginx:stable                                                              "/docker-entrypoint.sh nginx -g 'daemon off;'"   6 days ago   Up 26 hours   0.0.0.0:8080->80/tcp                       webserver
0e6b745b7cb772a5eb39a991129b3fba9521eb3af11147de9ab72494daba915e   postgres:latest                                                           "docker-entrypoint.sh postgres"                  8 days ago   Up 26 hours   0.0.0.0:5432->5432/tcp                     databaze
41d5f6af4e706f377a54d878db7c55a877fad734c9b5ffaf41e31b76b8e43b90   dpage/pgadmin4:latest                                                     "/entrypoint.sh"                                 9 days ago   Up 26 hours   0.0.0.0:80->80/tcp, 0.0.0.0:443->443/tcp   pg_admin


admin přihlášení do eshopu
	jméno: admin
	heslo: secret

