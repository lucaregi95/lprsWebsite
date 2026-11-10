<?php

require_once "../../bdd/bdd.php";
require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if( isset($_POST['ref_utilisateur']) && isset($_POST['ref_evenement'])){

    $repo = new ParticipeRepository();
    $participe = new Participe(2,$_POST['ref_utilisateur'],$_POST['ref_evenement']);
    $repo->ajouterParticipe($participe);
}
header("Location: ../../public/evenement.php");
exit();
