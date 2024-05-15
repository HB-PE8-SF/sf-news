# HB News

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)

Application fil rouge Symfony.

## Configuration

### Base de données

Dans le fichier `.env.local`, déclarer la variable d'environnement `DATABASE_URL`.

### Mailer

Dans le fichier `.env.local`, déclarer la variable d'environnement `MAILER_DSN`.

### Discord

Dans le fichier `.env.local`, déclarer la variable d'environnement `DISCORD_DSN`.

## Démarrage

Pour installer les dépendances :

```bash
composer install
```

Lancer ensuite l'application :

```bash
symfony serve --no-tls
```

Pour compiler le CSS avec Tailwind, **dans un second terminal**, exécuter la commande suivante :

```bash
php bin/console tailwind:build --watch
```
