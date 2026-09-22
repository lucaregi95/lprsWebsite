<?php

require_once "../bdd/bdd.php";
require_once "../model/Evenement.php";


if(isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['lieu']) && isset($_POST['element_requis']) && isset($_POST['nbr_places'])){
    $id_evenement = (isset($_POST['id_evenement'])) ? $_POST['id_evenement'] : null;


    $evenement = new Evenement($id_evenement,$_POST['titre'],$_POST['description'],$_POST['lieu'],$_POST['element_requis'],$_POST['nbr_places']);
}
