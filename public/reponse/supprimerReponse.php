<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Reponse.php';
require_once __DIR__ . '/../../src/repository/ReponseRepository.php';

$reponseRepository = new ReponseRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reponse'])) {
    $reponse = $reponseRepository->getReponse($_POST['id_reponse']);
    if ($reponse) {
        $reponseRepository->supprimerReponse($_POST['id_reponse']);
    }
}

header('Location: tabReponse.php');
exit;