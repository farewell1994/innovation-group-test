FROM mysql:8
WORKDIR /var/www/innovation-group-test
COPY docker/mysql/dump/dump.sql /docker-entrypoint-initdb.d/dump.sql
EXPOSE 3306
