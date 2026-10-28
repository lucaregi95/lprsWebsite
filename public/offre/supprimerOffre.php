<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Offre.php';
require_once __DIR__ . '/../../src/repository/OffreRepository.php';

$offreRepository = new OffreRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_offre'])) {
    $offre = $offreRepository->getOffre($_POST['id_offre']);
    if ($offre) {
        $offreRepository->supprimerOffre($_POST['id_offre']);
    }
}

header('Location: tabOffre.php');
exit;