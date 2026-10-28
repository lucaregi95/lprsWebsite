<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Entreprise.php';
require_once __DIR__ . '/../../src/repository/EntrepriseRepository.php';

$entrepriseRepository = new EntrepriseRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_entreprise'])) {
    $entreprise = $entrepriseRepository->getEntreprise($_POST['id_entreprise']);
    if ($entreprise) {
        $entrepriseRepository->supprimerEntreprise($_POST['id_entreprise']);
    }
}

header('Location: tabEntreprise.php');
exit;