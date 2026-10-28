<?php

require_once "../bdd/bdd.php";
require_once "../src/model/Evenement.php";
require_once "../src/repository/EvenementRepository.php";
require_once "../src/repository/UtilisateurRepository.php";
require_once "../src/model/Utilisateur.php";

if (!isset($_SESSION['id_utilisateur'])) {
header("Location: connexion.php");
exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$utilisateurRepo = new UtilisateurRepository();

if (!isset($_POST['prenom'])) {
$utilisateurRepo->modifierUtilisateur($id_utilisateur);
header("Location: profil.php?succes=modifier");
exit;
}

$utilisateur = $utilisateurRepo->getUtilisateur($id_utilisateur);
?>