# SNOW-TRICKS

## 2ème démo (ENV=prod) => http://symfony1.planetcode.fr

### Avancées
``` bash
* 5 entités : Figure (articles), Mention (commentaires), Classification (catégories), Member (membre) & Screen (médias)
* Liaisons multiples de clés étrangères
* Contraintes @Assert
* Ajout de CollectionType pour gérer les formulaires avec des liaisons entre les Entités
* Mise à jour de security.yaml pour la connexion et la déconnexion en tant que membre (ROLE USER)
* Possibilité d'éditer des images ou des vidéos dans chaque article : la table Screen stocke les images et les vidéos associées à l'article
* Dans BlogController, des modifications de la fonction createChapter() pour générer des champs d'éditions des images ou des vidéos associées à chaque article (prise en compte du paramètre $_GET pour changer le format de l'article et générer d'autres champs d'éditions pour un nouvel article)
* Dans les fichiers TWIG de création et de mise à jour d'un article, se trouve un système javascript de reconnaissance des URLS des images ou des vidéos Youtube entrées par l'utilisateur (reconnaissance des extensions valides des images et de plusieurs formats EMBED Youtube). Les champs d'éditions peuvent rester vides, mais si ils comportent des URLS erronées cela empêche de passer à la sauvegarde de l'article
* Tests d'envois de mails réussis avec des Tokens (inscription validée et nouveau mot de passe)
* Ajout des boutons de navigation en page d'accueil
* jQuery animation : bouton "Load More" en page d'accueil
* Upload d'images de profils membres lors de l'inscription sur le site + affichage fonctionnel des images sur les commentaires réservés aux membres
* Première version de fixture fonctionnelle qui génère des données liées entre les 5 entités 
```

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/diagrammes/Concepteur_BDD_SnowTricks_v2.JPG)
