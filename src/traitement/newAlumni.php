<?php
require_once '../bdd/bdd.php';
require_once '../model/Alumni.php';


if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['poste_occupe'])){
    $id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
    $date_inscription = (isset($_POST['date_inscription'])) ? $_POST['date_inscription'] : null;
    $statut_validation = (isset($_POST['statut_validation'])) ? $_POST['statut_validation'] : null;
    $ref_promotion = (isset($_POST['ref_promotion'])) ? $_POST['ref_promotion'] : null;
    $ref_entreprise = (isset($_POST['ref_entreprise'])) ? $_POST['ref_entreprise'] : null;
    $cv = (isset($_POST['cv'])) ? $_POST['cv'] : null;


    $alumni = new Alumni($id_utilisateur,$_POST["nom"],$_POST["prenom"],$_POST["email"], $_POST["mdp"],$date_inscription,$statut_validation,$cv,$_POST['poste_occupe'],$ref_promotion,$ref_entreprise);
}
