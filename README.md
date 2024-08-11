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



## Autenticazione
Per il momento ho 3 gruppi di rotte
1. ^/api
2. ^/api/login
3. ^/api/registration


Sono riuscito a proteggere tutte le rotte del primo tipo grazie a un JWT token.
Per fare ciò ho utilizzato il bundle di [Lexik](https://symfony.com/bundles/LexikJWTAuthenticationBundle/current/index.html)

Speriamo sia il metodo corretto per la gestione di queste cose
