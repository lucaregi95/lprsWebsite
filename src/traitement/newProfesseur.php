<?php
require_once '../bdd/bdd.php';
require_once '../model/Professeur.php';


if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['specialite'])){
    $id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
    $date_inscription = (isset($_POST['date_inscription'])) ? $_POST['date_inscription'] : null;
    $statut_validation = (isset($_POST['statut_validation'])) ? $_POST['statut_validation'] : null;



$professeur = new Professeur($id_utilisateur,$_POST["nom"],$_POST["prenom"],$_POST["email"], $_POST["mdp"],$date_inscription,$statut_validation,$_POST["specialite"]);
}




?>