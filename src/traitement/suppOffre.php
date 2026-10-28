<?php

require_once "../../bdd/bdd.php";
require_once "../model/Offre.php";
require_once "../repository/OffreRepository.php";

if (isset($_POST['id_offre'],$_POST['titre'])) {
    $idOffre = $_POST['id_offre'];

    $repository = new OffreRepository();
    $repository->supprimerOffre($idOffre);
}

header("Location: ../../public/offre.php");
exit;