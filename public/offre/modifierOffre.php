<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/OffreRepository.php';

$offreRepository = new OffreRepository();

if (isset($_POST['btn_submit'])) {
    $offre = new Offre(
        $_POST['id_offre'],
        $_POST['titre'],
        $_POST['description'],
        $_POST['mission'],
        $_POST['salaire'],
        $_POST['type_offre'],
        $_POST['etat'],
        $_POST['ref_entreprise'],
    );
    $offreRepository->modifierOffre($offre);
    header('Location: tabOffre.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabOffre.php');
    exit;
}

$offre = $offreRepository->getOffre($_GET['id']);
if (!$offre) {
    header('Location: tabOffre.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un offre</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le offre</h1>

<form method="post" action="modifierOffre.php">
    <label for="id_offre">ID</label>
    <input type="text" name="id_offre" id="id_offre" value="<?= $offre->getIdOffre() ?>" readonly><br>

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre" value="<?= $offre->getNom() ?>" required><br>

    <label for="description">Adresse</label>
    <input type="text" name="adresse" id="adresse" value="<?= $offre->getAdresse() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabOffre.php">Annuler</a>
</form>
</body>
</html>
