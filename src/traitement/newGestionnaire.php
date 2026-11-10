<?php

require_once __DIR__ .'/../../bdd/bdd.php';
require_once __DIR__ .'/../model/Gestionnaire.php';

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['date_inscription']) && isset($_POST['statut_validation'])) {
$id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
$ref_utilisateur = (isset($_POST['ref_utilisateur'])) ? $_POST['ref_utilisateur'] : null;

    $gestionnaire = new Gestionnaire($id_utilisateur, $_POST['nom'],$_POST['prenom'], $_POST['email'],$_POST['mdp'],$_POST['date_inscription'],$_POST['statut_validation'],$ref_utilisateur);
}


?>
