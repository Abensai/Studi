# Sujet: Groupe Hôtelier Hypnos
Studi ECF

Application Symfony permettant de réserver des suites du groupe hôtelier Hypnos

## Installation en local

### Pré-requis
* PHP 8.1
* Composer
* Symfony CLI
* Docker-compose
* nodejs et npm

Les pré-requis peuvent être vérifié avec la commande suivante {de la CLI Symfony}: {sauf pour la cas de Docker et Docker-compose}
```bash
symfony check:requirements
```
## Installation en local

```bash

```

## Lancer l'environnement de développement

```bash
composer install
npm install
npm run build
symfony serve:start -d

```

## Ajouter des données de tests
```bash
symfony console doctrine:fixtures:load
```

## Lancer tests en local
```bash
php bin/phpunit --testdox
```

## Usage

```python


# Commandes


# Front


# Back-Office

```
## Amélioration

### Envoie des mails de Contacts

Les mails de prise de contact sont stockés en base de données, pour les envoyer à l'admin par mail 
dans un second temps, il faudrait mettre en place un cron sur :
```bash
symfony console app:send-contact
```

## Amélioration


## License
Ali BEN SAIAD