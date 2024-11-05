Проект делал на Windows c OpenServer
Не упаковывал в докер, не использовал фреймворк, не использовал PDO, не использовал миграции.

Скачать проект на сервер с Апач.
Создать БД в пострессе

Создать таблицу

CREATE TABLE public.users (
id serial NOT NULL,
"name" varchar(50) NOT NULL,
email varchar NOT NULL,
created_at timestamp DEFAULT NOW() NOT NULL,
CONSTRAINT users_pk PRIMARY KEY (id),
CONSTRAINT users_unique UNIQUE (email)
);

В файле DbConnect подключение к БД
"host=localhost
port=5432
dbname=test_api
user=postgres
password=''

проект фронта https://github.com/Hanuman19/api-front

Ендпоинты:
/users (GET)
/users/1 (GET, DELETE)
/users (POST) форм дата имя емаил
/users/1 (PUT) JSON имя емаил