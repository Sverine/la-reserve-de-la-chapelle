# La Réserve de la Chapelle 📔🪄


Dans le cadre d'une évaluation lors de ma formation de développeur web et web mobile, j'ai été amenée à réaliser une application de médiathèque souhaitant mettre en place un système de click & collect.



## Contexte
Afin de limiter la propagation du virus Covid-19 lors du premier confinement, les bibliothèques et centres de documentation, au même titre que d'autres établissements recevant du public, ont dû fermer leurs portes. Victime elle aussi de cette contrainte et inspirée par le click and collect, la médiathèque de La Chapelle-Curreaux souhaite en profiter pour développer en interne une solution d’emprunt en ligne.

Les 42.500 livres (romans, bandes dessinées, albums pour enfants, documentaires) potentiellement disponibles à la lecture devraient figurer dans un annuaire accessible aux habitants des environs inscrits.

### Fonctionnalités attendues
- **Créer un compte**
  >   - L’habitant désirant s’inscrire devra renseigner : un nom, un prénom, un email valide, une date de naissance, son adresse postale et un mot de passe sécurisé résistant aux injections SQL.
  >   - Un employé devra obligatoirement vérifier les informations entrées. S’il décide de confirmer la création du compte, alors l’utilisateur pourra se connecter sur la plateforme.

- **Se connecter**
- **Découvrir le catalogue**
  >   - L’inscrit aura accès à l’intégralité du catalogue de la médiathèque. Un visuel permettra de différencier les livres disponibles de ceux qui ne le sont pas.
  >   - Si besoin, il peut rechercher un livre précis par son titre grâce à une barre de recherche ou filtrer par genre (ex : romance, science-fiction, fantastique, etc.)

-  **Emprunter un livre**
   >   -   Si le livre est disponible, un bouton associé permettra alors de l’emprunter.
   >   -   Si l’inscrit clique sur le bouton, le livre ne sera plus accessible pour d’autres utilisateurs.
   >   -   Lorsque l’inscrit vient pour récupérer son livre à la médiathèque, un employé confirmera l’emprunt.
   >   -   Si, au bout de 3 jours, le livre n’a toujours pas été récupéré par l’inscrit, l’emprunt sera considéré comme annulé et le livre sera de nouveau disponible dans le catalogue.

-   **Ajouter un livre dans le catalogue**
    >   -  Chaque livre possède : un titre, une image de couverture, une date de parution, une description, un auteur et un genre.

-   **Voir les emprunts en cours**
    >   -    Les employés de la médiathèque voient la liste des emprunts en cours. Tout livre dont la date de récupération par un inscrit date de plus 3 semaines devra être affiché en priorité.
    >   -    De son côté, l’inscrit voit aussi la liste des livres qu’il a empruntés. S’il est en retard dans un rendu, une notification de rappel sera affichée.

-   **Rendre un livre**
    >   -   Lorsqu’un inscrit vient rendre un livre sur place, un employé confirme la remise.
    >   -   Automatiquement, le livre devient à nouveau accessible dans le catalogue.



## Installation en local

Afin d'installer correctement le projet, il convient d'avoir un environnement de développement adapté pour Symfony.

- Cloner le projet :
  > ``git clone git@github.com:Sverine/la-reserve-de-la-chapelle.git``

- Modifier le fichier .env en fonction de votre environnement
- Installez les dépendances avec composer
  > ``composer install``

- Installez les dépendances gérées par Webpack
  > ``yarn install``

- Exécutez les migrations afin de récupérer la base de données
  > ``symfony console doctrine:migrations:migrate``

- Lancez les fixtures afin d'alimenter votre base de donnée local de quelques données
  > ``symfony console doctrine:fixtures:load``

- Compilez le SCSS et Javascript
  > ``yarn encore dev --watch``

- Lancez le serveur de Symfony
  > ``symfony server:start``

## Déployer l'application sur Heroku

Pour déployer ce projet, j'ai choisi d'utiliser Heroku.
Pour rendre compatible l'utilisation de Mysql, j'ai téléchargé l'addon JawsDB qui m'a généré un host, un username, un password et une database.
[Documentation JawsDB](https://devcenter.heroku.com/articles/jawsdb)

- Se connecter avec son compte Heroku
  >``heroku login``
- Créer un nouveau projet
  >  ``heroku create lareservedelachapelle``

- Configurer les variables d'environnement
  >  ``heroku config:set APP_ENV=prod``
  >  ``heroku config:set APP_SECRET=$(php -r 'echo bin2hex(random_bytes(16));')``

- Ajouter NodeJS au buildpack
  >  ``heroku buildpacks:add --index 1 heroku/nodejs``

- Faire un backup de sa base de donnée et utiliser ce backup pour alimenter la base de données fournie par JawsDB avec les infos disponibles depuis JawsDB dans l'onglet Ressources
    >  ``mysqldump -u root -p lareserve > backup.sql``
    >  ``mysql -h NEWHOST -u NEWUSER -pNEWPASS NEWDATABASE < backup.sql``

- Configurer la nouvelle URL de la base de donnée fournie par JawsDB
    >  ``heroku config:set DATABASE_URL=NEWDATABASE_URL``

- Pousser le déploiement
    > ``git push heroku main``



# ✨Aller plus loin ...

- **[Manuel d'utilisation](https://github.com/Sverine/la-reserve-de-la-chapelle/blob/main/pdf/manuel-utilisation.pdf)**

- **[Document technique](https://github.com/Sverine/la-reserve-de-la-chapelle/blob/main/pdf/document-technique.pdf)**

- **[Charte graphique](https://github.com/Sverine/la-reserve-de-la-chapelle/blob/main/pdf/charte-graphique.pdf)**

- **[Lien Trello](https://trello.com/invite/b/eFiPs8H4/abf31266a26bd669710a8bd545796e09/la-r%C3%A9serve-de-la-chapelle)**