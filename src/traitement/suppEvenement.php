<?php

require_once "../../bdd/bdd.php";
require_once "../model/Evenement.php";
require_once "../repository/EvenementRepository.php";

if (isset($_POST['id_evenement'],$_POST['titre'], $_POST['nbr_places'])) {
    $idEvenement = $_POST['id_evenement'];

    $repository = new EvenementRepository();
    $repository->supprimerEvenement($idEvenement);
}

header("Location: ../../public/evenement.php");
exit;

?>