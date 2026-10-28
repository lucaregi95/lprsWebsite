<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Formation.php';
require_once __DIR__ . '/../../src/repository/FormationRepository.php';

$formationRepository = new FormationRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_formation'])) {
    $formation = $formationRepository->getFormation($_POST['id_formation']);
    if ($formation) {
        $formationRepository->supprimerFormation($_POST['id_formation']);
    }
}

header('Location: tabFormation.php');
exit;