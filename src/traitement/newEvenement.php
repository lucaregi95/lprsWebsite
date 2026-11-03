<?php
session_start();
require_once "../../bdd/bdd.php";
require_once "../model/Evenement.php";
require_once "../repository/EvenementRepository.php";

require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if (empty($_SESSION['id_utilisateur'])) {
    header("Location: ../../public/evenement.php");
    exit;
}

if (isset($_POST['titre'], $_POST['description'], $_POST['lieu'], $_POST['nbr_places'], $_POST['lat'], $_POST['lng'],$_POST['date_evenement'])
    && $_POST['lat'] !== '' && $_POST['lng'] !== '') {

    $titre       = $_POST['titre'];
    $description = $_POST['description'];
    $lieu        = $_POST['lieu'];
    $nbr_places  = (int) $_POST['nbr_places'];
    $lat         = (float) $_POST['lat'];
    $lng         = (float) $_POST['lng'];
    $date_evenement = $_POST['date_evenement'];
    $id_user     = (int) $_SESSION['id_utilisateur'];

    if ($titre !== '' && $nbr_places > 0) {
        $evenement  = new Evenement(null, $titre, $description, $lieu, $nbr_places, $lat, $lng, $date_evenement);
        $repository = new EvenementRepository();
        $idEvenement =$repository->ajouterEvenement($evenement);

        $repo= new ParticipeRepository();
        $part= new Participe(1,$id_user,$idEvenement);
        $repo->ajoutParticipe($part);


    }
}

header("Location: ../../public/evenement.php");
exit;