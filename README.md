# Egal

## Serve project

1. Copy and edit `.env` file
2. Run once:
    ```shell
    docker-compose run --rm main-service composer install --dev
    docker-compose run --rm main-service npm install --save-dev
    ```
3. Run for serve:
    ```shell
    docker-compose up
    ```
