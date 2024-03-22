# innovation-group-test

In order to run app:
- make sure that _docker_ and _docker-compose_ services are installed on your machine
- clone GitHub repository to your machine
- copy .env.dist file to .env file (all parameters are correctly defined for work)
- run **make up** inside project directory for deployment
- run **make composer-install** inside project directory in order to install dependencies

Please, wait a while for the database to be imported

You may access to container console by command **make shell**

You have ready application for API demonstration.
Available by url: **localhost:8080/api/doc**

Also, you can run a command  **make test** in project in order to run tests

Run **make phpstan** or **make php_cs_fixer** for code control