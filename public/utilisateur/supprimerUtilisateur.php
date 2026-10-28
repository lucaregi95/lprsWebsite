<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Utilisateur.php';
require_once __DIR__ . '/../../src/repository/UtilisateurRepository.php';

$utilisateurRepository = new UtilisateurRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_utilisateur'])) {
    $utilisateur = $utilisateurRepository->getUtilisateur($_POST['id_utilisateur']);
    if ($utilisateur) {
        $utilisateurRepository->supprimerUtilisateur($_POST['id_utilisateur']);
    }
}

header('Location: tabUtilisateur.php');
exit;