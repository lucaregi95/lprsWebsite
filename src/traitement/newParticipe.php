<?php

require_once "../../bdd/bdd.php";
require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if(isset($_POST['id_participe']) && isset($_POST['est_orga']) && isset($_POST['ref_utilisateur']) && isset($_POST['ref_evenement'])){
    $id_participe = $_POST['id_participe'];

    $participe = new Participe($id_participe,$_POST['est_orga'],$_POST['ref_utilisateur'],$_POST['ref_evenement']);
}

