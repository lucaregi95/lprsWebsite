<?php

require_once '../../bdd/bdd.php';
require_once __DIR__ . "/../model/Entreprise.php";

if (isset($_POST['adresse']) && isset($_POST['nom_entreprise']) ){
    $id_entreprise= (isset($_POST['id_entreprise'])) ? $_POST['id_entreprise'] : null;
    $site_web = (isset($_POST['site_web'])) ? $_POST['site_web'] : null;
    $entreprise = new Entreprise($id_entreprise, $_POST['adresse'], $_POST['nom_entreprise'], $site_web);
}
