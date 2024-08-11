## Docker command for the DB creation for the project
```bash
docker run --rm \
--name symfony-test \
-e MYSQL_USER=user \
-e MYSQL_PASSWORD=secret \
-e MYSQL_ROOT_PASSWORD=secret \
-e MYSQL_DATABASE=SymfonyStudy \
-p 3306:3306 \
-v symfonyStudy:/var/lib/mysql \
-d \
mysql
```