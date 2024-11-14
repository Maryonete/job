# Gestion des Candidatures aux offres d'emploi

Ce projet est une application simple en PHP 8.2 pour gérer vos candidatures aux offres d'emploi. Il permet d'ajouter, de modifier et de supprimer des offres, ainsi que de suivre l'état de vos candidatures.

## Fonctionnalités

- Ajout d'une nouvelle offre d'emploi
- Modification des offres existantes
- Suppression des offres
- Gestion des candidatures (statut : en cours, refusée, acceptée)
- Interface utilisateur avec Bootstrap pour un design simple et responsive
- Connexion à une base de données MySQL pour stocker les informations des offres et des candidatures

## Technologies utilisées

- **PHP** 8.2
- **Bootstrap** (version la plus récente)
- **MySQL**
- **HTML/CSS** pour le front-end
- **PHPUnit** pour les tests unitaires

## Prérequis

- PHP 8.2 installé sur votre machine
- Serveur web local (Apache, Nginx)
- MySQL ou MariaDB
- Composer (pour la gestion des dépendances)
- PHPUnit pour les tests

## Installation

1. Clonez le dépôt sur votre machine locale :

   ```bash
   git clone https://github.com/Maryonete/job
   ```

2. Accédez au dossier du projet :

   ```bash
    cd gestion-candidatures
   ```

3. Installez les dépendances :

   ```bash
   composer install
   ```

4. Configuration de la base de données :
   Créez un fichier config/config.php avec les informations suivantes :

   ```bash
   ; Fichier config.php
   dbname=job
   host=localhost
   user=root
   password=
   ```

   Initialisez la base de données avec le script config/initDB.sql :

   ```bash
   mysql -u root -p < config/initDB.sql
   ```

5. Lancer le serveur PHP local sur le dossier /public :

   ```bash
   php -S localhost:8000 -t public
   ```

6. Accéder à l'application :
   ```bash
   http://localhost:8000
   ```

## Exemple de connexion

Vous pouvez utiliser les identifiants suivants pour vous connecter à l'application :

    * Email : **admin@job.com**
    * Mot de passe : **!v?ENBDBw4PT** (mot de passe déjà haché dans le script d'initialisation)

## Utilisation

Accédez à la page de connexion avec l'utilisateur par défaut.
Ajoutez, modifiez ou supprimez des offres d'emploi via l'interface.
Suivez l'état de vos candidatures et ajoutez des réponses si nécessaire.

## Améliorations futures

Ajout d'un système de filtrage et de recherche pour les offres
Authentification utilisateur améliorée avec JWT ou sessions sécurisées
Notifications par email pour les nouvelles réponses
Exportation des données des candidatures en CSV

## Contribuer

Les contributions sont les bienvenues ! Pour proposer des améliorations ou signaler des problèmes, veuillez ouvrir une issue ou une pull request.
