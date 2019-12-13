# Procédure d'installation
## Prérequis
- serveur web local
- PHP 7.3
## installation pour un utilisateur lambda
- Ouvrir un dossier en local.
- faire un git clone du repository
- composer update/install

## création de la base de données.

```bin/console doctrine:database:create```

## migration entités

1. Création du fichier de migration (code SQL) ```bin/console make:migration```
2. Executer la migration ```bin/console doctrine:migration:migrate```

## fixtures

1. les fixtures fonctionnent en mode développement (normalement).
```php bin/console doctrine:fixtures:load```



