<?php

require_once "../../bdd/bdd.php";
require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if (isset($_POST['id_evenement'],$_POST['id_user'])) {
    $idEvenement = $_POST['id_evenement'];
    $idUser = $_POST['id_user'];

    $repository = new ParticipeRepository();
    $repository->supprimerParticipe($idUser,$idEvenement);
}

header("Location: ../../public/evenement.php");
exit;

?>