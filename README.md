# Progetto
L'obiettivo di questa Repository è quello di aiutarmi a studiare il Framework Symfony.
Niente di più.\
Il progetto verrà effettuato completamente in chiave API.
Sarà presente un punto di autenticazione "^/api/login" e uno di registrazione "^/api/registration"
Tutti gli altri avranno bisogno di un JWT Token che viene generato automaticamente grazie al bundle di Lexik.
Maggiori info [qua](#autenticazione)

## Modelli
L'idea è quella di avere 4 modelli.
In realtà partirò implementandone solo 2 e man a mano aggiungerò complessità.
Questi modelli sono:
- User
- Post
- Comment
- UserInfo

Le relazioni sono così strutturate:
![](https://app.eraser.io/workspace/3DfYNU8YXRIgRNE8XBCh/preview?elements=qL66fbKOp8blcaXVjkEj1w&type=embed)]




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
