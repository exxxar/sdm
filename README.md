# Система дистанционного мониторинга

## Установка

Скачайте репозиторий в папку /var/www/html

    git clone -b main https://USERNAME@bitbucket.org/maksoft-sdm/sdm.git .

Установите зависимости composer

    composer install

Скопируйте пример env файла

    cp .env.example .env

Сгенерируйте ключ приложения

    php artisan key:generate

Откройте файл .env в любом редакторе (например nano)

    nano .env

Добавьте необходимые переменные среды

| **Необходимая** 	| **Ключ**              	| **Значение**            	|
|----------	|------------------	|------------------	|
| Нет      	| APP_NAME    	        | "Система дистанционного мониторинга" 	|
| Да      	| DB_CONNECTION 	    | mysql   	                            |
| Да 	    | DB_HOST    	        | 127.0.0.1     	                    |
| Да 	    | DB_PORT   	        | 3306           	                    |
| Да 	    | DB_DATABASE   	    | remote_monitoring_system              |
| Да 	    | DB_USERNAME   	    | root           	                    |
| Да 	    | DB_PASSWORD   	    | root           	                    |
| Да 	    | MAIL_DRIVER   	    | smtp           	                    |
| Да 	    | MAIL_HOST   	        | 127.0.0.1           	                |
| Да 	    | MAIL_PORT   	        | 25           	                        |
| Да 	    | MAIL_USERNAME   	    | sdm@mst4.me           	            |
| Да 	    | MAIL_PASSWORD   	    | Y7zPwaQqp8XXCLj           	        |
| Да 	    | MAIL_ENCRYPTION   	| ""           	                        |
| Да 	    | MAIL_FROM_ADDRESS   	| admin@sdm.com           	            |
| Да 	    | MAIL_FROM_NAME   	    | "${APP_NAME}"           	            |
| Да 	    | CAMERA_URL   	        | http://81.200.248.156:3000            |

## Настройки CRON

Откройте файл настроек cron

    crontab -e

Добавьте строку

    01 * * * * cd /var/www/html && php artisan job:logger >> /dev/null 2>&1

Перезапустите cron

    sudo service cron restart

## Настройки Supervisor

Установите Supervisor (инструкция по ссылке https://saywebsolutions.com/blog/installing-supervisor-manage-laravel-queue-processes-ubuntu)

На Step 5 по указанной выше инструкции установите следующую конфигурацию:

    [program:queue]
    process_name=%(program_name)s_%(process_num)02d
    command=sudo php /var/www/html/artisan queue:work database --tries=3 --daemon -vvv
    user=root
    autostart=true
    autorestart=true
    numprocs=1
    redirect_stderr=true
    stdout_logfile=/var/www/html/storage/logs/test.log


