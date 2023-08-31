
Для запуска данного проекта необходимо выполнить следующие действия:
1) Клонируем репозиторий:
  `git clone https://github.com/Yehorko/tz-laravel-vue.git`
2) Создать директорию "postgres" в папке /docker в которой база будет хранить данные
	
3) Запустить докер-контейнеры в корневой директории проекта:
    `docker compose up -d`
	
4) В php контейнере установить зависимости Laravel через composer и запустить миграции
	
 	`docker exec -it php-container /bin/bash`

	`composer install`

	`php artisan migrate`
6) Запустить в этом-же php контейнере обработчик очереди на парсинг файлов:
   `php artisan queue:work --queue=default`
   
   
После этого проект является полностью рабочим.

Фронтенд доступен по адресу можно проверять загрузку файлов:
   http://localhost:8074/#/
   
Админ панель базы Postgresql доступна по адресу:
http://localhost:8081/?pgsql=postgres%3A5432&username=jozeppe&db=laravel&ns=public
   
   
