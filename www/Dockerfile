
# Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
# Click nbfs://nbhost/SystemFileSystem/Templates/Other/Dockerfile to edit this template

FROM php:8.3-fpm

RUN apt update
RUN apt install -y libpq-dev
RUN docker-php-ext-configure pgsql 
RUN docker-php-ext-install pdo pgsql pdo_pgsql


