# Projet-1-D20.2
<b>Antoine BESNARD, Antoine MOTTE, Lucas FOUSSIER<b><br>


<b>Installation</b> :<br>
cp .env.dist .env <br>
docker-compose up -d <br>
docker-compose exec --user=application web composer install <br>
docker-compose exec web php bin/console d:s:u -f <br>


<b>Fonctionnalités</b> :<br>
 - Création d'Administrateur via la fonction create-admin (email et mdp en paramètres).
 - Inscription de l'utilisateur avec email, firstname, lastname, password en paramètres.
 - Ensemble de pages pour la gestion de conférence et d'utilisateur (voir URL ci-dessous).
 - Recherche des conférences par titre sur la page d'accueil.
 - Système de notation des conférences par les utilisateurs (allant de 1 à 5).
 - Liste des 10 conférences les plus votées.
 - Liste des conférences n"ayant pas de vote.
 - Administration des conférences (création, édition, suppression) et des utilisateurs (édition, suppression) par les administrateurs.
 - Système de fixtures (voir ci-dessous).

    
<b>URL</b>:<br>
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


<b>Gestion du Projet</b> : <br>
Utilisation de Projects dans l'interface Github suivant le schéma suivant : à faire / en cours / fini.<br>
Assignation des issues dans le projet, fermeture des issues complétées.<br>
Mise en place d'une protection de la branch <b>Master</b> pour éviter les commits inopportun.<br>
Création d'une branch correspondant à chaque issues et/ou chaque modification ou correction à apporter.<br>
Les commits sont effectués sur les branch auxiliaire suivi d'une pull request sur la branch <b>devlopment</b> sous approbation d'un collaborateur.<br>

<b>Fixtures</b> : <br>
Utiliser la commande php bin/console doctrine:fixtures:load pour executer les fixtures.<br>
UserFixtures.php génère un administrateur et 5 utilisateurs :<br>
Admin - Login : john@doe.com / Mdp : admin<br>
Chaque utilisateur est suivi d'un chiffre allant de 0 à 4, ils s'appellent tous john suivit de leur chiffre,
les mots de passe sont tous user suivit de ce même chiffre exemple : <br>
john0@doe.com / user0 <br>
john4@doe.com / user4 <br>

ConfFixtures.php génère 4 conférences<br>
Les informations de chaque conférences sont différentes.<br>
