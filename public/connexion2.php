<?php

require_once('../bdd/bdd.php');
require_once('../src/model/Utilisateur.php');
require_once ('../src/repository/UtilisateurRepository.php');

if (isset($_POST["email"])) {
    $email = $_POST["email"];
} else {
    $email = '';
}

if (isset($_POST["mdp"])) {
    $mdp = $_POST["mdp"];
} else {
    $mdp = '';
}

if(isset($_POST["page"])){
    $page  = $_POST["page"];}

$rep = new UtilisateurRepository();
$result = $rep->connecterUtilisateur($email, $mdp);

if (!$result) {
    header("Location: connexionActeur.php?erreur=inconnu");
    exit();
} else if ($result['etat']==0){
    header("Location: connexionActeur.php?erreur=bannir");
    exit();
} else if (!password_verify($mdp, $result['mdp'])) {
    header("Location: connexionActeur.php?erreur=unknown");
    exit();
}
else{

    session_start();
    $_SESSION['id']     = $result["id_utilisateur"];
    $_SESSION['nom']    = $result["nom"];
    $_SESSION['prenom'] = $result["prenom"];
    $_SESSION['email']  = $result["email"];

    header('Location: ../client/accueil.php');

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
