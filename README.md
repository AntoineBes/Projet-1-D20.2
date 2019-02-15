# Projet-1-D20.2
Antoine BESNARD, Antoine MOTTE, Lucas FOUSSIER<br>


Installation

cp .env.dist .env
docker-compose up -d
docker-compose exec --user=application web composer install
docker-compose exec web php bin/console d:s:u -f

Accéder au site

    Accéder a l'url du localhost:80

Fonctionnalités :
 - Création d'Administrateur via la fonction create-admin (email et mdp en paramètres).
 - Inscription de l'utilisateur avec email, firstname, lastname, password en paramètres.
 - Ensemble de pages pour la gestion de conférence et d'utilisateur (voir URL ci-dessous).
 - Recherche des conférences par titre sur la page d'accueil.
 - 

    
URL:
 - /homepage (page d'accueil)
 - /admin/user (liste de tout les utilisateurs)
 - /admin/user/{id} (édition/suppression d'utilisateurs)
 - /admin/conf (liste de toutes les conférences)
 - /admin/edit_conf (édition/suppression de conférence)
 - /user/{id} (édition des informations personnelles)
 - /subscribe (formulaire de création de compte utilisateur)
 - /voted (liste des 10 conférences les plus votées)
 - /unvoted (liste des conférences non votées)
 - /conf/{id} (voir les informations d'un conférence avec possibilité de voter et/ou s'inscrire)
 - /login (formulaire de connexion)
