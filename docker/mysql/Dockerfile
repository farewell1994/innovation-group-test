FROM mysql:8
WORKDIR /var/www/innovation-group-test
COPY docker/mysql/dump/innovation_group.sql /docker-entrypoint-initdb.d/init.sql
EXPOSE 3306