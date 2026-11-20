<?php
session_start();

require_once "../../bdd/bdd.php";
require_once __DIR__ . "/../model/Offre.php";
require_once __DIR__ . "/../repository/OffreRepository.php";
require_once __DIR__ . "/../repository/OffreUtilisateurRepository.php";
require_once __DIR__ . "/../model/OffreUtilisateur.php";

// Il faut être connecté pour publier une offre
if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: ../../public/connexion.php');
    exit();
}

if (isset($_POST['titre'], $_POST['description'], $_POST['mission'], $_POST['salaire'],
    $_POST['type_offre'], $_POST['etat'], $_POST['ref_entreprise'])) {

    $repo  = new OffreRepository();
    $offre = new Offre(null, $_POST['titre'], $_POST['description'], $_POST['mission'],
        $_POST['salaire'], $_POST['type_offre'], $_POST['etat'], $_POST['ref_entreprise']);
    $idOffre = $repo->ajouterOffre($offre);

    // Lien utilisateur <-> offre : 2 = celui qui gère l'offre (cf. offre.php)
    $rep = new OffreUtilisateurRepository();
    $oUtilisateur = new OffreUtilisateur($idOffre, $_SESSION['id_utilisateur'], 2);
    $rep->ajouterOffreUtilisateur($oUtilisateur);
}

header('Location: ../../public/offre.php');
exit();