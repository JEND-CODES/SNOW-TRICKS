# SNOW-TRICKS
- Projet symfony en cours de développement

### Première démo (ENV=prod) => http://symfony4.planetcode.fr

## Avancées
- 4 entités créées avec Doctrine (Figure, Mention, Classification & Member)
- Liaisons de clés étrangères définies dans les Entités et entre les tables SQL
- Paramétrages multiples des Entités avec des contraintes @Assert
- Ajout de CollectionType pour gérer les formulaires avec des liaisons entre les Entités
- Mise à jour de security.yaml pour la connexion et la déconnexion en tant que membre (ROLE USER)
- Possibilité d'éditer des images ou des vidéos dans chaque article : la table Screen stocke les images et les vidéos associées à l'article
- Dans BlogController, des modifications de la fonction createChapter() pour générer des champs d'éditions des images ou des vidéos associées à chaque article (prise en compte du paramètre $_GET pour changer le format de l'article et générer d'autres champs d'éditions pour un nouvel article)
- Dans les fichiers TWIG de création et de mise à jour d'un article, se trouve un système javascript de reconnaissance des URLS des images ou des vidéos Youtube entrées par l'utilisateur (reconnaissance des extensions valides des images et de plusieurs formats EMBED Youtube). Les champs d'éditions peuvent rester vides, mais si ils comportent des URLS erronées cela empêche de passer à la sauvegarde de l'article

![SNOWTRICKS](https://raw.githubusercontent.com/JEND-CODES/SNOW-TRICKS/main/Concepteur_BDD_SnowTricks_v1.png)
