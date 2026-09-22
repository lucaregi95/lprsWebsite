<?php

require_once "../bdd/bdd.php";
require_once "../model/Offre.php";

if(isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['mission'])&& isset($_POST['salaire']) && isset($_POST['type_offre']) && isset($_POST['etat']) && isset($_POST['ref_entreprise'])){
    $id_offre = (isset($_POST['id_offre'])) ? $_POST['id_offre'] : null;


    $offre = new Offre($id_offre,$_POST['titre'],$_POST['description'],$_POST['mission'],$_POST['salaire'], $_POST['type_offre'], $_POST['etat'], $_POST['ref_entreprise']);
}
