# LPRSWebsite

LPRSWebsite est un site web dédié à la gestion des anciens élèves (alumni) et aux relations avec les entreprises. Ce site servira de plateforme centrale pour renforcer les liens entre l'école, ses anciens élèves, et les partenaires. L'objectif est de faciliter la communication, le réseautage, et la collaboration, tout en offrant des services supplémentaires aux anciens élèves et aux entreprises. 

#  Prérequis et installation
## Prérequis :

- Base de donnée opérationnelle, 
- 1 compte Administrateur,
- Dépendances installées,
- Composer installé,
- phpMyAdmin installé

## Installation : 
1. Cloner le repository avec : `git clone https://github.com/lucaregi95/lprsWebsite`
2. Installer les dépendances avec : `composer install`<br>
*Veuillez noter que composer doit être deja installé dans votre système*
3. Télécharger la Base de donnée (BDD) : "Nom à donner"
4. Importez la BDD dans phpMyAdmin
5. Creer un dossier config dans la racine du projet, dans ce dernier ajouter un fichier php : `mail`
6. Dans ce fichier, ajouter ce qui suit : <br>
   ```
   <?php
   return [
   'host' => '', //doit contenir votre host de mail
   'port' => , //doit contenir le port de votre host de mail
   'username' => '', //doit contenir l'adresse mail
   'password' => '', //doit contenir le mot de passe d'application
   'from' => '', //doit contenir l'adresse mail
   'fromName' => '', //doit contenir le nom qui va etre affiché lors de l'envoi
   ];
   ``` 