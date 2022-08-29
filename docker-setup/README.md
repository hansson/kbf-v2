## Prerequisites
- docker
- docker-compose

## Starting with docker
Make sure the docker daemon is running:
```
sudo service docker start
```

Navigate to this folder and run:
```
sudo docker-compose up
```

## Connecting to sql-client using docker
Make sure you use the configured user and password in docker-compose.yml.

```
sudo docker exec -it docker-setup_mysql_1 mysql -u testuser -ppassword kbf
```

## Importing SQL file
The kbf.sql file is mounted into the mysql container. Once connected with a sql-client the file can be imported with the following command:
```
source /kbf.sql
```

## PHP config
For 'mysql_address' use the container name for the mysql instance. 

´´´
...
'mysql_address' => "docker-setup_mysql_1",
...
´´´