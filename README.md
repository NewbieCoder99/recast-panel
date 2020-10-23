# ReCast

## What is ReCast?

ReCast is a multi platform streaming tool written in PHP and uses nginx RTMP. You can stream through one server to multiple services

## Installation

* You have to install a nginx server [Tutorial](https://github.com/recastin/panel/wiki/Install-Nginx-RTMP)
* Checkout this project
* Run ```composer install --no-dev -o```
* Run ``php bin/console recast:setup``
* Create the tables ```php bin/console doctrine:migrations:migrate```
* Create a new user with ```php bin/console recast:create:user```
* Create a new crontab entry which runs every minute ```php bin/console recast:cron```
* Environment variable ``APP_HOST`` should point to a http server, nginx rtmp does not support https.

### Environment variable overview
| Name                      | Description                                                       | Example                                          |
|---------------------------|-------------------------------------------------------------------|--------------------------------------------------|
| APP_HOST                  | URL which is used in nginx rtmp conf, This address must be http   | http://try.recast.in                             |
| APP_ENV                   | Which environment it runs                                         | prod                                             |
| APP_REGISTRATION_ENABLED  | Toggles registration form                                         | true                                             |
| DATABASE_URL              | Database credentials as URL                                       | DATABASE_URL=mysql://USER:PASS@HOST:3306/DB_NAME |
| NGINX_CONFIG_DIR          | Folder where nginx.conf is located                                | /opt/nginx-rtmp/conf/                            |
| NGINX_RELOAD_COMMAND      | Reload command for nginx rtmp                                     | systemctl reload nginx-rtmp                      |

## Free hosted version

We have also on https://app.recast.in a free to use ReCast setup.

**Docker Setup will be following**

## Screenshots

![Dashboard](https://i.imgur.com/6gcqWTh.png)

![List Streams](https://i.imgur.com/E5FVy9K.png)

![Edit Stream](https://i.imgur.com/PHYjnQn.png)

![Add Endpoint](https://i.imgur.com/bYteEQR.png)

![Setup](https://i.imgur.com/ZfP7Tpv.png)