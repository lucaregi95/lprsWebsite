<?php

require_once "../bdd/bdd.php";
require_once "../model/Entreprise.php";


if(isset($_POST['adresse']) && isset($_POST['nom_entreprise']) && isset($_POST['site_web'])){
    $id_entreprise = (isset($_POST['id_entreprise'])) ? $_POST['id_entreprise'] : null;


    $entreprise = new Entreprise($id_entreprise,$_POST['adresse'],$_POST['nom_entreprise'],$_POST['site_web']);
}