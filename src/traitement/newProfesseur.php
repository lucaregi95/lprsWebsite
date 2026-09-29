<?php
require_once '../bdd/bdd.php';
require_once '../model/Professeur.php';

if(isset($_POST['specialite']) && isset($_POST['ref_professeur'])) {
    $id_utilisateur = (isset($_POST['id_utilisateur'])) ? $_POST['id_utilisateur'] : null;
    $description = (isset($_POST['$description'])) ? $_POST['$description'] : null;
    $missions = (isset($_POST['missions'])) ? $_POST['missions'] : null;
    $salaire = (isset($_POST['salaire'])) ? $_POST['salaire'] : null;
    $type_offre = (isset($_POST['type_offre'])) ? $_POST['type_offre'] : null;
    $etat = (isset($_POST['etat'])) ? $_POST['etat'] : null;
    $ref_professeur = (isset($_POST['ref_professeur']));
    $specialite = (isset($_POST['specialite']));
    $titre = (isset($_POST['titre'])) ? $_POST['titre'] : null;



$professeur = new Professeur($id_utilisateur,$titre,$description, $missions, $salaire, $type_offre, $etat,$ref_professeur,$specialite);
}




?>