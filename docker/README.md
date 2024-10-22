# Приложение на Симфони (Отчет)

Репозиторий содержит контейнер для запуска приложения в директории docker,
код приложения в app.
Приложение - CRUD для отчета,

## 1. Термины

- Symfony — фреймворк основного контейнера (php-fpm). Можно почитать [здесь](https://symfony.com/doc/current/index.html)

## 2. Используемые технологии

Основные технологии: PHP, Redis, PostgreSQL, RabbitMQ
Код пишем на PHP

### 2.1 Общие технологии

| Технология | Версия          | Описание         | Ссылка                     |
|------------|-----------------|------------------|----------------------------|
| PHP        | 8.3             | PHP              | https://www.php.net        |
| PostgreSQL | 16.0-alpine3.17 | Реляционная БД   | https://www.postgresql.org |
| Nginx      | 1.25.4          | Прокси-сервер    | https://www.nginx.com      |
| RabbitMQ   | 7.2.1           | Брокер сообщений | https://www.rabbitmq.com   |          

## 3. Подготовка окружения для запуска

1. Проверить, что установлен Git
    ```shell
    git -v
    ```
2. Установить [Docker-compose](https://docs.docker.com/compose/install/linux/#install-the-plugin-manually).

3. Проверить, что установлен php
    ```shell
    php -v
    ```
   если нет установить [php](https://www.php.net/downloads).

4. Проверить, что установлен composer
   ```shell
   composer
   ```
   если нет установить [composer](https://getcomposer.org/download/).

## 4. Установка

1. Склонировать репозиторий в текущую директорию
    ```shell
    git clone git@github.com:Vanzhin/otus-report.git
    ```
2. Создать файлы .env путем их копирования из .env.example в директориях docker и app
    ```shell
    cd ./docker
    ```
3. Перейти в директорию с файлом docker-compose.yaml
    ```shell
    cd ./docker
    ```

## 5. Запуск

   ```shell
   docker build --platform linux/amd64 -t vanzhin/report:v1.5.1 .
   ```

   ```shell
   docker run -d  -p 9000:8000 vanzhin/report:v1.5.1
   ```

После чего, в браузере можно открыть страницу https://localhost:9000

*Profit !*