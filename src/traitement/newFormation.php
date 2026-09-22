<?php


require_once "../bdd/bdd.php";
require_once "../model/Formation.php";

if(isset($_POST['nom_formation'])){
    $id_formation = (isset($_POST['id_formation'])) ? $_POST['id_offre'] : null;


    $offre = new Formation($id_formation, $_POST['nom_formation']);
}