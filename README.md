# Projet-1-D20.2
Antoine BESNARD, Antoine MOTTE, Lucas FOUSSIER<br>


<b>Installation</b> :
cp .env.dist .env <br>
docker-compose up -d <br>
docker-compose exec --user=application web composer install <br>
docker-compose exec web php bin/console d:s:u -f <br>


<b>Fonctionnalités</b> :
 - Création d'Administrateur via la fonction create-admin (email et mdp en paramètres).
 - Inscription de l'utilisateur avec email, firstname, lastname, password en paramètres.
 - Ensemble de pages pour la gestion de conférence et d'utilisateur (voir URL ci-dessous).
 - Recherche des conférences par titre sur la page d'accueil.
 - Système de notation des conférences par les utilisateurs (allant de 1 à 5).
 - Liste des 10 conférences les plus votées.
 - Liste des conférences n"ayant pas de vote.
 - Administration des conférences (création, édition, suppression) et des utilisateurs (édition, suppression) par les administrateurs.
 

    
<b>URL</b>:
 - /homepage (page d'accueil)
 - /admin/user (liste de tout les utilisateurs)
 - /admin/user/{id} (édition/suppression d'utilisateurs)
 - /admin/conference (liste de toutes les conférences)
 - /admin/edit_conference (édition/suppression de conférence)
 - /user/{id} (édition des informations personnelles)
 - /subscribe (formulaire de création de compte utilisateur)
 - /voted (liste des 10 conférences les plus votées)
 - /unvoted (liste des conférences non votées)
 - /conf/{id} (voir les informations d'un conférence avec possibilité de voter et/ou s'inscrire)
 - /login (formulaire de connexion)


<b>Gestion du Projet</b> :
Utilisation de Projects dans l'interface Github suivant le schéma suivant : à faire / en cours / fini.
Assignation des issues dans le projet, fermeture des issues complétées.
Mise en place d'une protection de la branch <b>Master</b> pour éviter les commits inopportun.
Création d'une branch correspondant à chaque issues et/ou chaque modification ou correction à apporter.
Les commits sont effectués sur les branch auxiliaire suivi d'une pull request sur la branch <b>devlopment</b> sous approbation d'un collaborateur.

