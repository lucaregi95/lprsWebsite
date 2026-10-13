<?php
require_once '../bdd/Bdd.php';
require_once '../model/Alumni.php';

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['date_inscription']) && isset($_POST['statut_validation']) && isset($_POST['ref_promotion']) ) {
    $id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
    $ref_utilisateur = (isset($_POST['ref_utilisateur'])) ? $_POST['ref_utilisateur'] : null;
    $ref_entreprise = (isset($_POST['ref_entreprise'])) ? $_POST['ref_entreprise'] : null;
    $poste_occupe = (isset($_POST['poste_occupe'])) ? $_POST['poste_occupe'] : null;
    $cv = (isset($_POST['cv'])) ? $_POST['cv'] : null;
    $mdp= $_POST['mdp'];
    if (substr($mdp, 0, 4) != '$2y$') {//compare les 4 caracteres a partir du caractere 0
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);

        // comme le fichier sert a la fois pour l'ajout ET la modif, ca evite de re hasher un mdp deja hasher
    }




    $alumni = new Alumni($id_utilisateur,$_POST['nom'],$_POST['prenom'], $_POST['email'], $mdp, $_POST["date_inscription"], $_POST["statut_validation"],$ref_utilisateur,$cv,$poste_occupe,$_POST['ref_promotion'],$ref_entreprise);
}