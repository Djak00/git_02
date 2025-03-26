# git_02_SYMFONY
Description_git_02 - projets_symfony

Initialisation & Base de données
- Création d'un projet Symfony
- Configuration de la base de données avec Doctrine
- Utilisation des migrations et des fixtures pour insérer des données

Gestion des Routes & Pages
- Définition des routes et création des contrôleurs
- Affichage dynamique des données dans les templates Twig
- Mise en place d'une page d'accueil

Manipulation des Données (Doctrine ORM)
- Création et gestion des entités
- Utilisation des repositories pour interagir avec la base de données
- Modification des données via les formulaires Symfony

Relations entre Entités
- Gestion des relations OneToOne (1:1) et OneToMany (1:n)
- Création de relations ManyToMany (n:n)
- Exploitation des relations pour afficher les données liées (ex. : animaux et familles, continents, personnes)
  
Développement d'API REST
- Création d’un contrôleur API : ApiAlimentController
- Création de routes d’API via les annotations :
- Récupération de données au format JSON
- Structuration des réponses JSON (return $this->json(...))
- Utilisation de l’outil Postman ou du navigateur pour tester les endpoints


Tests
- Configuration de l’environnement de test (.env.test, phpunit.xml.dist)
- Création de tests fonctionnels avec PHPUnit
- tests/controller/ApiAlimentControllerTest.php
- Vérification des réponses API (assertResponseIsSuccessful, assertJson…)

Technologies utilisées
- Symfony
- Doctrine ORM
- Twig
- PHP
- MySQL
- PHPUnit
- API Platform - contrôleurs manuels
- Postman (pour tester les endpoints API)
