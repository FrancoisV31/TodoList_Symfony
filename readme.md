# Application symfony TodoList;
## Install symfony version 4.x.x
__Terminal__ :  
   ``` composer create-project symfony/website-skeleton my_project_name "4.4.*"```

## Etapes de développement:  
### clone github procédure  
A faire
### database
1. Config database dans .env :  
  ```DATABASE_URL=mysql://root:@127.0.0.1:3306/db_todolist```     
2. Création physique de la base de données  
```bin/console doctrine:database:create``` 
### Entités
les types de données de l'application:  
On a deux entités qui apparaissent:   _Category_ et _todo_   
    1. Category(id, name)  
    2. Todo(id, title, content, createdAt, updatedAt, todoFor)    

__Terminal__ :  
Pour créer les deux entités : ```php bin/console make entity```  
Commencer par Category puis Todo.  
La relation se fera à partir de l'entité Todo, avec une propriété _category_id_ qui sera du type __relation__  
### Migrations

1. Création du fichier de migration (code SQL) ```bin/console make:migration```
2. Executer la migration ```bin/console doctrine:migration:migrate```
    --> crée les tables Todo et Category dans mySql  

## Git commit
1. git add
2. git commit -m "Todo application install et config DB"

#fixtures
tester insertion de données dans les tables.  
Installer d'abord : ```composer require orm-fixtures --dev```
