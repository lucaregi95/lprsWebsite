<?php

require_once "../../bdd/bdd.php";
require_once "../model/OffreUtilisateur.php";
require_once "../repository/OffreUtilisateurRepository.php";

if(isset($_POST['ref_utilisateur']) && isset($_POST['ref_offre'])){

    $repo= new OffreUtilisateurRepository();
    $oU = new OffreUtilisateur('ref_offre','ref_utilisateur');
    $repo ->modifierOffre($oU);

    header('Location: ../../public/offre.php');
    exit();
}

header('Location: ../../public/offre.php');
exit();
