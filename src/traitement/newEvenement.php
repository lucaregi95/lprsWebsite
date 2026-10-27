<?php

require_once "../../bdd/bdd.php";
require_once "../model/Evenement.php";
require_once "../repository/EvenementRepository.php";


if(isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['lieu'])  && isset($_POST['nbr_places'])){
    $id_evenement = (isset($_POST['id_evenement'])) ? $_POST['id_evenement'] : null;


    $evenement = new Evenement($id_evenement,$_POST['titre'],$_POST['description'],$_POST['lieu'],$_POST['nbr_places']);

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $lieu = $_POST['lieu'];
    $nbr_places = $_POST['nbr_places'];

    if ($titre > 0) {

        $evenement = new Evenement(null, $titre, $description, $lieu, $nbr_places);
        $repository = new EvenementRepository();
        $repository->ajouterEvenement($evenement);

        header("Location: ../../public/evenement.php");
        exit;
    }
}else{
    header("Location: ../../public/evenement.php");
    exit;
}
