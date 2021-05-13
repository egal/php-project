# Egal Framework microservice

For config docker-compose.yml:

```yml
  monolit-service:
    container_name: ${PROJECT_NAME}-monolit-service
    build: ${PATH_TO_SERVICE}
    volumes:
      - ${PATH_TO_SERVICE}:/app
    environment:
    APP_SERVICE_NAME: ${APP_SERVICE_NAME}
    APP_SERVICE_KEY: ${APP_SERVICE_KEY}
    DB_HOST: ${PROJECT_NAME}-database
    DB_DATABASE: ${APP_SERVICE_NAME}
    DB_PASSWORD: ${DATABASE_PASSWORD:-password}
    RABBITMQ_HOST: ${PROJECT_NAME}-rabbitmq
    RABBITMQ_PORT: 5672
    RABBITMQ_USER: ${RABBITMQ_USERNAME:-admin}
    RABBITMQ_PASSWORD: ${RABBITMQ_PASSWORD:-password}
    WAIT_HOSTS: ${PROJECT_NAME}-rabbitmq:5672, ${PROJECT_NAME}-database:5432
    depends_on:
        - rabbitmq
        - database
```
