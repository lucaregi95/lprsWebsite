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
    <input type="text" name="titre" id="titre" value="<?= $offre->getTitre() ?>" required><br>

    <label for="description">Description</label>
    <input type="text" name="description" id="description" value="<?= $offre->getDescription() ?>" required><br>

    <label for="mission">Mission</label>
    <input type="text" name="mission" id="mission" value="<?= $offre->getMission() ?>" required><br>

    <label for="salaire">Salaire</label>
    <input type="text" name="salaire" id="salaire" value="<?= $offre->getSalaire() ?>" required><br>

    <label for="type_offre">Type de l'offre</label>
    <input type="text" name="type_offre" id="type_offre" value="<?= $offre->getTypeOffre() ?>" required><br>

    <label for="etat">Etat</label>
    <input type="text" name="etat" id="etat" value="<?= $offre->getEtat() ?>" required><br>

    <label for="ref_entreprise">Entreprise</label>
    <input type="text" name="ref_entreprise" id="ref_entreprise" value="<?= $offre->getRefEntreprise() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabOffre.php">Annuler</a>
</form>
</body>
</html>
