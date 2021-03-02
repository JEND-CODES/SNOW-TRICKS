# SNOW-TRICKS

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/304f528b398a466fbe59f9d97595f1a4)](https://www.codacy.com/gh/JEND-CODES/SNOW-TRICKS/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=JEND-CODES/SNOW-TRICKS&amp;utm_campaign=Badge_Grade)

## DÉMO => http://symfony1.planetcode.fr

### DIAGRAMMES

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/Cas_Gestion_Tricks_P6_V1-Page-1.png)

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/S%C3%A9quence_Inscription_P6_V1.png)

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/S%C3%A9quence_New_Password_P6_V1-Page-1.png)

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/Diagramme_de_Classes_P6_V1.png)

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/Mod%C3%A8le_de_donn%C3%A9es_P6_V1.png)

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/Concepteur_BDD_SnowTricks_v4.JPG)

### INSTRUCTIONS D'INSTALLATION
``` bash
* CLONEZ LE PROJET : git clone https://github.com/JEND-CODES/SNOW-TRICKS

* INSTALLEZ LES DÉPENDANCES AVEC COMPOSER : composer install

* IMPORTEZ LE FICHIER DE DÉMONSTRATION DANS VOTRE BASE DE DONNÉES : snowtricks.sql

* INDIQUEZ VOTRE SMTP DANS LE FICHIER .ENV : MAILER_DSN=smtp://user:pass@smtp.example.com:port

* LANCEZ VOTRE SERVEUR LOCAL POUR VISUALISER LE SITE
```

### Avancées
``` bash
* 5 entités

* Liaisons multiples de clés étrangères

* Contraintes @Assert

* Ajout de CollectionType pour gérer les formulaires avec des liaisons entre les Entités

* Mise à jour de security.yaml pour la connexion et la déconnexion en tant que membre (ROLE USER)

* La table Screen stocke les images et les vidéos associées à l article

* Dans BlogController, prise en compte du paramètre $_GET pour changer le format de l article

* Reconnaissance des extensions valides des images et de plusieurs formats EMBED Youtube

* Tests d envois de mails réussis avec des Tokens (inscription validée et nouveau mot de passe)

* Ajout des boutons de navigation en page d accueil

* jQuery animation : bouton LOAD MORE en page d accueil

* Upload et affichages d images de profils membres

* Fixtures fonctionnelles (composer require FakerPhp)

* Relation établie entre entités Member et Figure

* Pagination révisée sur les commentaires

* Affichage photo membre connecté dans la sidebar

* Mise en place des SLUGS URL

* Révisions multiples Entités, Controllers, Fixtures

* Révision Slugs avec SluggerInterface

* RepositoryFigure : recherche d articles par mots clés

* UserChecker : vérification du statut membre

* Asserts Unicity sur l Entité Member (email & username)

* Symfony Mailer fonctionnel (désactivation Swift Mailer)

* Elaboration des diagrammes : cas, séquences, classes

* Prise en compte ROLE_ADMIN dans security.yml

* Révision formulaire NEW PASSWORD dans SecurityController

* Création AdminController : gestion Posts et Commentaires

* Révisions Entité Member, Fixtures, NewPassType

* Révision liens CSS et JS avec asset() dans les Templates Twig
```