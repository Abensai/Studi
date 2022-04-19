# Sujet: Groupe Hôtelier Hypnos
Studi ECF

Application Symfony permettant de réserver des suites du groupe hôtelier Hypnos

## Pré-requis
* PHP 7.4
* Composer 2.2.9
* Symfony CLI 5.4.1
* nodejs 16.14.0
* npm 8.5.5

Les pré-requis peuvent être vérifié avec la commande suivante {de la CLI Symfony}:
```bash
symfony check:requirements
```

### Installation en local

  - Dans votre dossier local faire un git clone:
```python
git clone https://github.com/Abensai/Studi.git
```
  - rejoindre la racine du projet
```python
cd ./Studi
```
   - Installer les bundles et toutes les dependances avec composer
```python
composer install
```
   - créer un fichier à la racine .env.local et y copier le contenu présent dans le fichier dèjà présent .env
   - dans votre fichier .env.local, modifier la ligne suivante avec vos identifiants de base de données local (l. 30)
```python
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```
  - renseigner les informations suivantes:
        - db_user
        - db_password
        - num du server par défault à 3306
        - db_name

  - créer une base de données avec la commande suivante: par default db_name = database
```python
symfony console doctrine:database:create {db_name}
```  
   - importer les tables vides dans cette nouvelle bdd (database) avec la commande suivante: confirmer avec yes
```python
symfony console doctrine:migrations:migrate
``` 
  - importer les données dans les tables vides avec la commande suivante: confirmer avec yes   
```python
symfony console doctrine:fixtures:load 
``` 
   - installer les dependances avec npm
```python
npm install
```
   - créer les fichiers public avec la commande suivante:
```python
npm run build
```
   - lancer la commande symfony server
```python
symfony server:start -d
```

### Lancer l'environnement de développement

```bash
composer install
npm install
npm run build
symfony server:start -d
```

### Ajouter des données de tests
```bash
symfony console doctrine:fixtures:load
```

### Lancer tests en local
#### Créer ENV=test
Créer une bdd de test, 
```bash
symfony console doctrine:database:create --env=test
```
jouer les migrations et fixtures
```bash
symfony console doctrine:migrations:migrate -n --env=test
symfony console doctrine:fixtures:load -n --env=test
```
#### Tests Technique
```bash
php bin/phpunit --testdox
```
#### Tests Fonctionnel
```bash

```
#### Tests Coverage
```bash
php bin/phpunit --coverage-html var/log/test/test-coverage
```

## Usage

```python

# Front
login admin:
    email: admin@admin.com
    password: password
login manager:
    email: manager-one@manager.com
    password: password

# Back-Office
le fichier des fixtures créé un user admin
email: admin@admin.com
lien: /admin
roles permissions: ROLE_ADMIN, ROLE_MANAGER

la modification des users, des etablissement, et des roles par 
l'administrateur va pouvoir se faire depuis le back-office

le manager va pouvoir modifier les suites, après que l'admin lui ai
ajouté le role ROLE_MANAGER depuis de back-office 
```

## Envoie des mails de Contacts

Les mails de prise de contact sont stockés en base de données, pour les envoyer à l'admin par mail 
dans un second temps, il faudrait mettre en place un cron sur :
```bash
symfony console app:send-contact
```

## Amélioration


## License
Ali BEN SAIAD