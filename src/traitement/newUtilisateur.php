<?php
require_once "../bdd/bdd.php";
require_once "../model/Utilisateur.php";

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['mdp'])){
    $id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
    $date_inscription = (isset($_POST['date_inscription'])) ? $_POST['date_inscription'] : null;
    $statut_validation = (isset($_POST['statut_validation'])) ? $_POST['statut_validation'] : null;



$mdp= $_POST['mdp'];
    if (substr($mdp, 0, 4) != '$2y$') {//compare les 4 caracteres a partir du caractere 0
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);

        // comme le fichier sert a la fois pour l'ajout ET la modif, ca evite de re hasher un mdp deja hasher
    }
$utilisateur = new Utilisateur($id_utilisateur, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $mdp,$date_inscription, $statut_validation);


}