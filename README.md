# Задание 8: Веб-сервис с REST API

## Описание
Веб-сервис для приёма данных формы в формате JSON/XML с интеграцией фронтенда.

## Технологии
- PHP 7+
- MySQL/MariaDB
- HTML5/CSS3/JavaScript (Fetch API)
- Учебный фреймворк Initlab

## REST API
- `POST /api/applications` - создание заявки (возвращает login, password, profile_url)
- `PUT /api/applications/{id}` - обновление заявки (требует HTTP Basic Auth)
- `GET /api/applications/{id}` - получение данных заявки

## Установка
1. Импортировать db.sql в MySQL
2. Настроить подключение в settings.php
3. Загрузить файлы на сервер
4. Открыть главную страницу

## Функционал
- Отправка формы через JavaScript (Fetch API)
- Фоллбек на обычную отправку если JS отключен
- Клиентская и серверная валидация
- Генерация логина и пароля
- HTTP Basic Auth для API