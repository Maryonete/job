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

   1. Créer le fichier de configuration local :

   Copiez le fichier config/config.example.php et renommez-le en config/config.local.php. Ce fichier ne sera pas suivi par Git pour protéger vos informations sensibles.

   ```bash
   cp config/config.example.php config/config.local.php
   ```

   2. Modifiez le fichier config/config.local.php avec les informations de votre base de données :

      ```bash
      ; Fichier config.local.php
      dbname=job
      host=localhost
      user=root
      password=
      ```

   3. Ajoutez le fichier config.local.php à .gitignore pour éviter qu'il ne soit versionné :

   Dans le fichier .gitignore, ajoutez :

   ```bash
   # Fichier de configuration local
   /config/config.local.php
   ```

   4. Initialisez la base de données avec le script SQL config/initDB.sql :

      ```bash
      mysql -u root -p < config/initDB.sql
      ```

   5. Utilisez un fichier d'exemple pour les autres développeurs : Le fichier config/config.example.php est inclus dans le dépôt et doit contenir une structure de base sans informations sensibles.
      ```bash
      ; Fichier config.example.php
      dbname=
      host=
      user=
      password=
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

    * Email : admin@job.com
    * Mot de passe : !v?ENBDBw4PT (mot de passe déjà haché dans le script d'initialisation)

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
