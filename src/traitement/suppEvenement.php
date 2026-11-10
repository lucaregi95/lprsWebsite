<?php

require_once "../../bdd/bdd.php";
require_once "../model/Evenement.php";
require_once "../repository/EvenementRepository.php";
require_once "../model/Participe.php";
require_once "../repository/ParticipeRepository.php";

if (isset($_POST['id_evenement'],$_POST['titre'], $_POST['nbr_places'])) {
    $idEvenement = $_POST['id_evenement'];

    $repository = new EvenementRepository();
    $repoParticipe = new ParticipeRepository();


    $connexionBdd = (new Bdd())->getConnexionBdd();
    $sql = "SELECT COUNT(*) FROM participe WHERE ref_evenement = $idEvenement";
    $req = $connexionBdd->prepare($sql);
    $result=$req->execute();

    if ($result == null){
        $repository->supprimerEvenement($idEvenement);
    }else{
        $repoParticipe->supprimerAllParticipesByEvenement($idEvenement);
        $repository->supprimerEvenement($idEvenement);
    }
}

header("Location: ../../public/evenement.php");
exit;

?>