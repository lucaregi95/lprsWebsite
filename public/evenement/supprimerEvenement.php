<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Evenement.php';
require_once __DIR__ . '/../../src/repository/EvenementRepository.php';

$evenementRepository = new EvenementRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evenement'])) {
    $evenement = $evenementRepository->getEvenement($_POST['id_evenement']);
    if ($evenement) {
        $evenementRepository->supprimerEvenement($_POST['id_evenement']);
    }
}

header('Location: tabEvenement.php');
exit;