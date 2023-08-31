
Для запуска данного проекта необходимо выполнить следующие действия:
1) Клонируем репозиторий:
	git clone https://github.com/Yehorko/tz-laravel-vue.git
	
2) Запустить докер-контейнеры в корневой директории проекта:
    docker compose up -docker
	
3) В php контейнере установить зависимости Laravel через composer и запустить миграции
	docker exec -it php-container /bin/bash
	composer install
	php artisan migrate
4) Запустить в этом-же php контейнере обработчик очереди на парсинг файлов:
   php artisan queue:work --queue=default
   
   
После этого проект является полностью рабочим.

Фронтенд доступен по адресу можно проверять загрузку файлов:
   http://localhost:8074/#/
   
Админ панель базы Postgresql доступна по адресу:
http://localhost:8081/?pgsql=postgres%3A5432&username=jozeppe&db=laravel&ns=public
   
   
