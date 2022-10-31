#ECF Décembre 2022 - Studi


#### Projet API salle de sport

Objectifs :
L’objectif du projet est de mener une étude (Analyse des besoins) et développer l’application web présentée ci-dessous. Il convient également d’élaborer un dossier d’architecture web qui documente entre autres les choix des technologies, les choix d’architecture web et de configuration, les bonnes pratiques de sécurité́ implémentées, etc.
Il est également demandé d’élaborer un document spécifique sur les mesures et bonnes pratiques de sécurité́ mises en place et la justification de chacune d’entre elles. Les bases de données et tout autre composant nécessaire pour faire fonctionner le projet sont également accompagnés d’un manuel de configuration et d’utilisation.

### Déploiement

* Clôner le dépôt
* Dans le répertoire, taper `composer install`, pour installer les dépendances nécessaires au projet.
* Ensuite `php bin/console doctrine:database:create`, pour créer la base de données.
* Puis `php bin/console doctrine:migrations:migate`, pour insérer les tables nécessaires au projet.
* Et enfin `php bin/console doctrine:fixtures:load`, afin d'avoir des entrées dans la base de données.