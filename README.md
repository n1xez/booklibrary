# booklibrary

## Installation
### 1) Необходимо поднять тестовую среду 
(php 7+, apache|nginx, mysql 5.7, composer)
### 2) В папку проекта необходимо скопировать git repository
```git
$ git clone https://github.com/n1xez/booklibrary.git
```
### 3) Загрузите зависимости
```bash
$ composer install
```
### 4) Настройте .env (Укажите параметры соединения с БД, параметры среды и т. д.)
```text
APP_ENV=local
APP_KEY=base64:G7sAPvtgkArBCsTHA9Pf95yudu8uCeu5GLbh2RuC5RY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booklibrary
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```
### 5) Запустите Миграции (в проекте laravel)
```bash
$ php artisan migrate
```
### 6) Запустите сидер для создания фейковых книг (в проекте laravel)
```bash
$ php artisan db:seed
```

## USAGE
### In Level 1 
### 1) Save scanner input
Для проверки работы следует запустить запрос POST /scan с параметрами:
```json
{
    "isbn": <int>, 
    "author_full_name": <string>, 
    "title": <string>,
    "year": <int>
}
```
«isbn» уникальный параметр если уже будет найдена книга с таким параметром то она будет перезаписана 
### 2) Get authors top 100
Для проверки работы следует запустить запрос GET /top_authors без параметров
### 3) Get books by author
Для проверки работы следует запустить запрос GET /books с параметрами:
/books?author_full_name={{ Имя автора в кодировке url }}

### In Level 2
### 1) Update “Get books by author” method
Этот метод реализован через тот же роут что и "Get books by author" GET /books
/books?author_full_name={{ Неточное имя автора в кодировке url }}
### 2) Update “Save scanner input” method
Логгер пишет информацию в папку проекта app/storage/logs/scans.log
### 3) Get books in a range of years
Этот метод реализован через тот же роут что и "Get books by author" но с другими параметрами GET /books
/books?date_from={{ Параметр от }}&date_to={{ Параметр до }}

Вы можете комбинировать например
/books?date_from=2000&date_to=2100&author_full_name=Guiller
### 4) Get average number of books per year by an author
Для проверки работы следует запустить запрос GET /average_by_years без параметров

