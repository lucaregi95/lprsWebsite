<?php

ini_set('display_errors', 5);
error_reporting(E_ALL);

$connexion = null;
require_once('../bdd/bdd.php');
require_once('../src/repository/UtilisateurRepository.php');

$utilisateur = new UtilisateurRepository();

// Récupération des données du formulaire de connexion
$email = $_POST["email"];
$mdp   = $_POST["mdp"];
if(isset($_POST["page"])){
    $page  = $_POST["page"];}




if (!$result) {
    // Aucun utilisateur trouvé : redirection avec message d'erreur
    header("Location: connexion.php?erreur=unknown");
} else {

    session_start();
    // Stockage des informations de l'utilisateur en session
    $_SESSION['id']     = $result["id_utlisateur"];
    $_SESSION['nom']    = $result["nom"];
    $_SESSION['prenom'] = $result["prenom"];
    $_SESSION['email']  = $result["email"];

    header("location:acceuil.php");

    ?>
    <!DOCTYPE html>
    <html lang=fr>
    <head>
        <meta charset="UTF-8">
        <title>Connexion en Cours</title>
        <link href="../style/style_public/connexion2.css" rel="stylesheet">
    </head>
    <body>
    </body>
    </html>
<?php } ?><?php
