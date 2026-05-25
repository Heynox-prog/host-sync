# Host Sync

Projet full-stack développé dans un cadre d’apprentissage et d’expérimentation autour du développement web, de l’authentification et de la gestion de contenu dynamique. Son utilisation en production est déconseillée.

---

## Aperçu du projet

Host Sync est un projet personnel conçu afin de pratiquer le développement d’applications web complètes.

Le projet inclut :

- un système d’authentification utilisateur,
- une gestion de services et d’offres,
- un système d’articles dynamiques,
- une gestion de base de données MySQL,
- une interface responsive,
- des fonctionnalités backend en PHP.

L’objectif principal du projet est l’apprentissage, l’expérimentation et l’amélioration de mes compétences en développement web full-stack.

---

## Fonctionnalités

### Authentification

- Connexion / inscription
- Gestion des rôles
- Système de vérification
- Réinitialisation de mot de passe
- Gestion des tokens utilisateur

### Gestion de contenu

- Création et gestion d’articles
- Gestion de services
- Gestion d’offres dynamiques

### Interface

- Interface responsive
- Navigation dynamique
- Organisation modulaire du projet

---

## Technologies utilisées

### Front-end

- HTML
- CSS
- JavaScript

### Back-end

- PHP
- MySQL

### Outils

- Git
- GitHub
- PHPMailer

---

## Base de données

Le projet contient un fichier `schema.sql` correspondant uniquement à la structure de la base de données.

Aucune donnée personnelle, sensible ou de production n’est incluse dans le dépôt GitHub.

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Heynox-prog/host-sync.git
```

### 2. Accéder au dossier

```bash
cd host-sync
```

### 3. Installer les dépendances

Installer PHPMailer avec Composer :

```bash
composer install
```

ou :

```bash
composer require phpmailer/phpmailer
```

### 4. Configurer l’environnement

Créer un fichier `.env` ou modifier les fichiers de configuration selon votre environnement local.

Exemple :

```env
DB_HOST=localhost
DB_NAME=host_sync
DB_USER=root
DB_PASSWORD=
```

### 5. Importer la base de données

Importer le fichier `schema.sql` dans MySQL.

---

## Structure du projet

```text
host-sync/
├── admin/
│   │└── database/
│   │   └── schema.sql
├── articles/
├── dashboard/
├── in-developement/
├── legal/
├── services
├── static
└── user
```

---

## Objectifs du projet

Ce projet m’a permis de pratiquer :

- le développement full-stack,
- la conception de bases de données,
- l’authentification utilisateur,
- l’organisation d’un projet web,
- la gestion de contenu dynamique,
- Git et GitHub,
- le développement responsive.

---

## Important

Ce projet a été réalisé dans un but éducatif et expérimental.

Il n’est pas conçu pour être utilisé en production sans amélioration importante de la sécurité, de l’architecture et de l’infrastructure.

---

## Auteur

Piotr Kowalewski

- GitHub : https://github.com/Heynox-prog