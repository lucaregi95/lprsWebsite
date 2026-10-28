<?php

require_once "../../bdd/bdd.php";
require_once "../model/Evenement.php";
require_once "../repository/EvenementRepository.php";

if (isset($_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nbr_places'], $_POST['lat'], $_POST['lng'])
    && $_POST['lat'] !== '' && $_POST['lng'] !== '') {
    $idEvenement = $_POST['id_evenement'];
    $titre       = $_POST['titre'];
    $description = $_POST['description'];
    $lieu        = $_POST['lieu'];
    $nbr_places  = (int) $_POST['nbr_places'];
    $lat         = (float) $_POST['lat'];
    $lng         = (float) $_POST['lng'];
    $date_evenement = $_POST['date_evenement'];

    if ($titre !== '' && $nbr_places > 0) {
        $evenement  = new Evenement($idEvenement, $titre, $description, $lieu, $nbr_places, $lat, $lng, $date_evenement);
        $repository = new EvenementRepository();
        $repository->modifierEvenement($evenement);
    }
}

header("Location: ../../public/evenement.php");
exit;