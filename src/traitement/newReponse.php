<?php

require_once "../../bdd/bdd.php";
require_once __DIR__ ."/../../src/model/Reponse.php";

if(isset($_POST['contenu']) && isset($_POST['datetime_reponse']) && isset($_POST['ref_utilisateur'])&& isset($_POST['ref_post'])){
    $id_reponse = (isset($_POST['id_reponse'])) ? $_POST['id_reponse'] : null;


    $reponse = new Reponse($id_reponse,$_POST['contenu'],$_POST['datetime_reponse'],$_POST['ref_utilisateur'],$_POST['ref_post']);
}