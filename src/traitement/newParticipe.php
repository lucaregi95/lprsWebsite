<?php

require_once "../../bdd/bdd.php";
require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if( isset($_POST['ref_utilisateur']) && isset($_POST['ref_evenement'])){

    $repo = new ParticipeRepository();
    $participe = new Participe(null,0,$_POST['ref_utilisateur'],$_POST['ref_evenement']);
    $repo->ajoutParticipe($participe);
}
header("Location: ../../public/evenement.php");
exit();
