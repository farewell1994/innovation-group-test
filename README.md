# innovation-group-test

In order to run app:
- make sure that 'docker' and 'docker-compose' services are installed on your machine
- clone GitHub repository to your machine
- copy .env.dist file to .env file (all parameters are correctly defined for work)
- run 'make up' inside project directory for deployment
- run 'make composer-install' inside project directory in order to install dependencies

You may access to container console by command 'make shell'

You have ready application for API demonstration.
Available by url: localhost:8080/api/doc

Also, you can run a commands:
- 'make test' in project in order to run tests
