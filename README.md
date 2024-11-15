# Gestion des Candidatures aux Offres d'Emploi

[![PHP Version](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://www.php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Une application PHP moderne pour la gestion efficace de vos candidatures aux offres d'emploi. Cette solution permet de suivre, organiser et gérer professionnellement votre recherche d'emploi.

## 📑 Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Tests](#tests)
- [Feuille de route](#feuille-de-route)
- [Contribution](#contribution)
- [Licence](#licence)

## ✨ Fonctionnalités

- **Gestion complète des offres d'emploi**
  - Création, modification et suppression d'offres
  - Suivi détaillé des candidatures
  - Statuts personnalisables (en cours, refusée, acceptée)
- **Interface moderne et responsive**
  - Design épuré avec Bootstrap
  - Navigation intuitive
  - Compatible tous supports
- **Sécurité renforcée**
  - Authentification utilisateur
  - Protection des données sensibles
  - Validation des entrées

## 🔧 Prérequis

- PHP 8.2 ou supérieur
- Serveur web (Apache/Nginx)
- MySQL 5.7+ ou MariaDB 10.3+
- Composer
- Extension PHP requises :
  - PDO PHP Extension
  - MySQL PHP Extension
  - PHP-XML

## 📦 Installation

1. **Clonage du dépôt**

```bash
git clone https://github.com/Maryonete/job
cd gestion-candidatures
```

2. **Installation des dépendances**

```bash
composer install
```

3. **Configuration de l'environnement**

```bash
cp config/config.example.php config/config.local.php
```

4. **Initialisation de la base de données**

```bash
mysql -u root -p < config/initDB.sql
```

5. **Démarrage du serveur de développement**

```bash
php -S localhost:8000 -t public
```

## ⚙️ Configuration

### Base de données

Modifiez le fichier `config/config.local.php` avec vos paramètres :

```php
; Configuration de la base de données
dbname = "job"
host = "localhost"
user = "votre_utilisateur"
password = "votre_mot_de_passe"
```

### Accès par défaut

- **Email** : admin@job.com
- **Mot de passe** : !v?ENBDBw4PT

## 🚀 Utilisation

1. Accédez à `http://localhost:8000`
2. Connectez-vous avec les identifiants par défaut
3. Commencez à gérer vos candidatures :
   - Créez de nouvelles offres
   - Suivez l'état de vos candidatures
   - Ajoutez des notes et commentaires

## 🧪 Tests

Exécution des tests unitaires :

```bash
./vendor/bin/phpunit tests
```

## 📝 Feuille de route

- [ ] Système de filtrage et recherche avancée
- [ ] Authentification JWT
- [ ] Notifications par email
- [ ] Export des données (CSV, PDF)
- [ ] API RESTful
- [ ] Interface d'administration avancée

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/amelioration`)
3. Committez vos changements (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`)
4. Poussez vers la branche (`git push origin feature/amelioration`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📬 Contact

Pour toute question ou suggestion, n'hésitez pas à :

- Ouvrir une issue
- Contacter l'équipe de développement via le dépôt GitHub
