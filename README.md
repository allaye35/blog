# Blog Personnel

Ce projet est un blog personnel développé avec le framework Symfony. Il permet aux utilisateurs de créer des articles, de les commenter et de gérer les utilisateurs et les rôles.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les logiciels suivants :

- [PHP](https://www.php.net/downloads) (version 7.4 ou supérieure)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)
- [MySQL](https://dev.mysql.com/downloads/installer/) (ou tout autre base de données compatible Doctrine)

## Installation

1. Clonez le dépôt du projet :

    ```bash
    git clone https://github.com/votre-utilisateur/votre-repo.git
    ```

2. Accédez au répertoire du projet :

    ```bash
    cd votre-repo
    ```

3. Installez les dépendances PHP avec Composer :

    ```bash
    composer install
    ```

4. Créez une base de données MySQL pour le projet. Utilisez les identifiants de connexion MySQL par défaut :

    - **Nom d'utilisateur** : root
    - **Mot de passe** : (laisser vide)

5. Configurez votre fichier `.env` pour définir les paramètres de connexion à la base de données :

    ```dotenv
    DATABASE_URL="mysql://root:@127.0.0.1:3306/nom_de_la_base_de_donnees"
    ```

6. Créez les tables de la base de données et exécutez les migrations :

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

7. Chargez les fixtures (données d'exemple) si nécessaire :

    ```bash
    php bin/console doctrine:fixtures:load
    ```

## Utilisation

1. Lancez le serveur de développement Symfony :

    ```bash
    symfony serve
    ```

2. Ouvrez votre navigateur et accédez à l'URL suivante pour voir le site en action :

    ```
    http://127.0.0.1:8000
    ```

3. Connectez-vous en tant qu'administrateur avec les informations suivantes :

    - **Email** : admin@admin.com
    - **Mot de passe** : admin

## Fonctionnalités

- **Gestion des utilisateurs** : Inscription, connexion et déconnexion des utilisateurs.
- **Gestion des articles** : Création, édition et suppression d'articles.
- **Commentaires** : Ajout de commentaires sur les articles.
- **Rôles** : Différents rôles pour les utilisateurs (ROLE_USER, ROLE_ADMIN).
- **Mots-clés** : Association de mots-clés aux articles.

## Structure du projet

- `src/Controller` : Contient les contrôleurs du projet.
- `src/Entity` : Contient les entités Doctrine.
- `src/Repository` : Contient les repositories pour les entités.
- `templates` : Contient les templates Twig pour le rendu des vues.
- `migrations` : Contient les migrations de base de données.

## Contribution

Les contributions sont les bienvenues ! Pour signaler un problème ou proposer une amélioration, veuillez ouvrir une issue ou une pull request sur GitHub.

## Auteur

- **Votre Nom** - [Votre Profil GitHub](https://github.com/votre-utilisateur)

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
