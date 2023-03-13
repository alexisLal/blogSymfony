[PHP 8.1](https://www.php.net/downloads)

- [MySQL 8](https://dev.mysql.com/downloads/)
- [Symfony CLI](https://symfony.com/download)
- [Git](https://git-scm.com/)
- [Node et NPM](https://nodejs.org/en/)
- [Composer](https://getcomposer.org/)

## Installation

Cloner le projet :

```bash
git clone liengit
```

Créer une base de données sur votre machine locale. (avec MYSQL Workbench par exemple)

Créer un .env.local pour remplir les variables d'environnement.

Importer une base de données depuis la production ou executer la commande suivante pour récupérer la structure de données :

```bash
symfony console doctrine:migrations:migrate
```

Installer les dépendances php du projet :

```bash
composer install
```

Pour faire tourner le serveur symfony et accéder à l'application :

```bash
symfony serve -d
```

## Git workflow

Il y a deux branches principales :

`main` correspond à la version stable du projet. Cette branche est
celle déployée en production.

Il y a ensuite des branches secondaires :

`feat/nom-de-la-feature`

On crée une branche avec ce nom pour développer une fonctionnalité. Une
fois terminée, on pousse notre branche sur Github et on fait une
pull request vers dev.

`fix/exemple`

On crée une branche en ce nom, pour corriger un bug en production.
Ensuite, PR vers dev et master.
