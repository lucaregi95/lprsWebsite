<?php

require_once "../bdd/bdd.php";
require_once "../model/Reponse.php";

if(isset($_POST['contenu']) && isset($_POST['date_reponse']) && isset($_POST['ref_inscrit'])&& isset($_POST['ref_sujet'])){
    $id_reponse = (isset($_POST['id_reponse'])) ? $_POST['id_reponse'] : null;


    $reponse = new Reponse($id_reponse,$_POST['contenu'],$_POST['date_reponse'],$_POST['ref_inscrit'],$_POST['ref_sujet']);
}