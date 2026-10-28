<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/EntrepriseRepository.php';

$entrepriseRepository = new EntrepriseRepository();

if (isset($_POST['btn_submit'])) {
    $entreprise = new Entreprise(
        $_POST['id_entreprise'],
        $_POST['adresse'],
        $_POST['nom_entreprise'],
        $_POST['site_web'],
    );
    $entrepriseRepository->modifierEntreprise($entreprise);
    header('Location: tabEntreprise.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabEntreprise.php');
    exit;
}

$entreprise = $entrepriseRepository->getEntreprise($_GET['id']);
if (!$entreprise) {
    header('Location: tabEntreprise.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un entreprise</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le entreprise</h1>

<form method="post" action="modifierEntreprise.php">
    <label for="id_entreprise">ID</label>
    <input type="text" name="id_entreprise" id="id_entreprise" value="<?= $entreprise->getIdEntreprise() ?>" readonly><br>

    <label for="adresse">Adresse</label>
    <input type="text" name="adresse" id="adresse" value="<?= $entreprise->getAdresse() ?>" required><br>

    <label for="nom_entreprise">Nom de l'entreprise</label>
    <input type="text" name="nom_entreprise" id="nom_entreprise" value="<?= $entreprise->getNomEntreprise() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabEntreprise.php">Annuler</a>
</form>
</body>
</html>
