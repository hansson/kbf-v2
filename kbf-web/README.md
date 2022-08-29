## Requirements
* Mysql/mariadb
* Some webserver with php support

## Installation
* Copy `kbf.config.php.template` to `kbf.config.php` and replace username and password fields.
* Import `kbf.sql` to your database instance
* Goto `http://127.0.0.1/admin/login.php`
* Login with user `admin@test.com` and password `test`

## Installing using docker
See docker-setup folder.

## Add user to mariadb
* Connect to mariadb with a admin user
* `CREATE DATABASE `db`;`
* `CREATE USER 'local' IDENTIFIED BY 'local';`
* `GRANT USAGE ON *.* TO 'local'@localhost IDENTIFIED BY 'local';`
* `GRANT ALL privileges ON `db`.* TO 'myuser'@localhost;`
* `FLUSH PRIVILEGES;`