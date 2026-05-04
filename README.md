# SideQuest - Laravel 10 + Vue 3 SPA

Этот проект был успешно перенесен с чистого PHP на стек **Laravel 10 (API)** + **Vue 3 (SPA)**.

## Требования

-   PHP 8.1+
-   Composer
-   Node.js 18+
-   npm или yarn
-   MySQL 5.7+ или MariaDB 10.3+

## Установка

1.  **Клонируйте репозиторий** (если еще не сделано).
2.  **Установите зависимости PHP:**
    ```bash
    composer install
    ```
3.  **Создайте базу данных** `sidequest` в вашем MySQL.
4.  **Скопируйте `.env.example` в `.env` и настройте подключение к БД:**
    ```bash
    cp .env.example .env
    # Отредактируйте файл .env, укажите ваши DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```
5.  **Сгенерируйте ключ приложения:**
    ```bash
    php artisan key:generate
    ```
6.  **Запустите миграции и сидеры:**
    ```bash
    php artisan migrate --seed
    ```
7.  **Установите зависимости фронтенда:**
    ```bash
    npm install
    ```
8.  **Соберите фронтенд:**
    ```bash
    npm run build
    # Или для разработки с hot-reload:
    # npm run dev
    ```

## Запуск

-   Для локальной разработки используйте встроенный сервер Laravel:
    ```bash
    php artisan serve
    ```
    Приложение будет доступно по адресу `http://localhost:8000`.

## Структура проекта

-   **Backend (Laravel):**
    -   `app/Models`: Модели Eloquent (`User`, `Product`).
    -   `app/Http/Controllers`: API-контроллеры.
    -   `database/migrations`: Миграции базы данных.
    -   `database/seeders`: Сидеры для тестовых данных.
    -   `routes/api.php`: Маршруты API.
-   **Frontend (Vue 3):**
    -   `resources/js`: Исходный код Vue SPA.
        -   `components`: Компоненты приложения.
        -   `views`: Страницы (виды).
        -   `router`: Настройка маршрутизации.
    -   `resources/views/app.blade.php`: Точка входа для SPA.

## Функционал

-   Регистрация и вход пользователей.
-   Просмотр каталога VR-игр.
-   Просмотр детальной страницы игры.
-   Добавление бесплатных игр в библиотеку.
-   Просмотр личной библиотеки.
-   Админка (будет реализована позже).

Приятной работы с новым проектом!