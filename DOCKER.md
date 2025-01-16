
## Setup Docker
Run command below to start build process
```
docker build . -t pbtaxand:1.0.3 
```
When build process is finished run the containers by ``docker-compose up``.
Start redis by executing the command
```
docker exec app service redis-server start
```
At this point you should be able to access the webpage by typing the host address which is ``http://localhost:8080`` in your browser.

But to access the data needed for the web, you need to import sql file in migration folder by following these steps
- Get into application/migrations/backupdb

> [!IMPORTANT]
> Make sure your terminal are inside of ``pbtaxand-ci`` directory
- Run the command below
```
docker exec cp pbtaxand.sql app_mysql:/docker-entrypoint-initdb.d
```
There should be success message if the copy ran successfully
- Run the command below to import database from sql file
```
docker exec -it app_mysql mysql -u root
``` 
```
use pbtaxand;
```
```
pbtaxand < docker-entrypoint-initdb.d/pbtaxand.sql;
```
- The web should be ready to use when the import operation is finished