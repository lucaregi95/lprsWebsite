<?php


require_once "../../bdd/bdd.php";
require_once __DIR__ . "/../model/Formation.php";

if(isset($_POST['nom_formation'])){
    $id_formation = (isset($_POST['id_formation'])) ? $_POST['id_formation'] : null;
    $nom_formation = (isset($_POST['nom_formation'])) ? $_POST['nom_formation'] : null;


    $formation = new Formation($id_formation, $nom_formation);
}