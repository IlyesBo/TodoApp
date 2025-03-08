# Documentation du projet Symfony - Gestion des réservations

Ce projet est un Travail Pratique réalisé à l'université Gustave Eiffel à Meaux.  
Il a été conçu par **Ilyès Bouziane**, étudiant en BUT MMI pour apprendre à créer une application Symfony pour gérer une liste de tâches avec un CRUD basique. Le projet inclut la création de l'entité Task, la gestion des tâches (ajout, modification, suppression) et leur filtrage. Un bonus propose d'améliorer l'interface avec Bootstrap et d'ajouter une API REST.


## Sommaire

1. [Introduction](#introduction)
2. [Comment démarrer le projet ?](#comment-démarrer-le-projet)
   - [Prérequis](#1-prérequis)
   - [Étapes pour cloner et lancer le projet](#2-étapes-pour-cloner-et-lancer-le-projet)
3. [Tester le projet](#3-tester-le-projet)
4. [Auteur](#4-auteur)
---

## Introduction

Ce projet a pour objectif de permettre aux utilisateurs :
- De créer, modifier, supprimer et marquer comme terminé des tâches
- De filtrer les tâches.
- D'utiliser une API pour récuperer les tâches.
- 
**Note** : Le projet est fonctionnel à 100%, si vous rencontrez des erreurs, veuillez me contacter.

---

## Comment démarrer le projet ?

### 1. Prérequis

Avant de commencer, assurez-vous que les outils suivants sont installés :
- **PHP** (>= 8.4)
- **Composer**
- **Symfony CLI**
- **PostgreSQL** ou une base de données compatible

### 2. Étapes pour cloner et lancer le projet

1. **Cloner le projet** :
   ```bash
   git clone https://github.com/IlyesBo/TodoApp.git
   cd TodoApp

Installer les dépendances :

composer install

Configurer la base de données :

    Créez un fichier .env.local :

cp .env .env.local

Ajoutez les informations de connexion :

    DATABASE_URL="pgsql://postgres:password@127.0.0.1:5432/todoapp"

Initialiser la base de données :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Lancer le serveur Symfony :

    symfony server:start

    L'application sera accessible à http://localhost:8000.

## 3. Tester le projet
Routes utilisateur

    Routes disponibles
1. Page d'accueil (Liste des tâches)
![image](https://github.com/user-attachments/assets/0c89217b-f097-4e24-ac54-25e6ff37bd96)


    URL : /task

    Méthode HTTP : GET
                   
    Description : Affiche la liste des tâches avec des filtres pour les tâches terminées ou en cours. Poossibilité d'ajouter une tâche, de modifier, supprimer et marquer comme terminé.

    Lien : http://localhost:8000/task
   
![image](https://github.com/user-attachments/assets/f44db46b-4703-43db-b7c2-d58c318e20a4)

![image](https://github.com/user-attachments/assets/088de7cc-8b7a-4486-b074-455098cc6b1c)

2. API REST pour récupérer les tâches en JSON
   ![image](https://github.com/user-attachments/assets/dc0289ce-3da4-4fb0-8d28-c8bcc547014f)


    URL : /api/tasks

    Méthode HTTP : GET

    Description : Retourne la liste des tâches au format JSON.

    Lien : http://localhost:8000/api/tasks

Toutes les routes :
Routes

    Liste des tâches

        GET /task → TaskController::index

        Affiche les tâches (filtres : terminées/en cours).

    Créer une tâche

        GET|POST /task/new → TaskController::new

        Formulaire + traitement.

    Détails d'une tâche

        GET /task/{id} → TaskController::show

        Affiche les détails.

    Modifier une tâche

        GET|POST /task/{id}/edit → TaskController::edit

        Formulaire + traitement.

    Supprimer une tâche

        POST /task/{id} → TaskController::delete

        Supprime une tâche (token CSRF requis).

    Marquer comme terminée

        POST /task/{id}/complete → TaskController::markAsCompleted

        Marque une tâche comme terminée (token CSRF requis).

    API REST (JSON)

        GET /api/tasks → Api\TaskController::index

        Retourne les tâches en JSON.


## 4. Auteur

Ce projet a été conçu et réalisé par Ilyès Bouziane.
