<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/SiteRepository.php';

$siteRepository = new SiteRepository();

if (isset($_POST['btn_submit'])) {
    $site = new Site(
        $_POST['id_site'],
        $_POST['nom'],
        $_POST['adresse']
    );
    $siteRepository->modifierSite($site);
    header('Location: tabSite.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabSite.php');
    exit;
}

$site = $siteRepository->getSite($_GET['id']);
if (!$site) {
    header('Location: tabSite.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un site</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le site</h1>

<form method="post" action="modifierSite.php">
    <label for="id_site">ID</label>
    <input type="text" name="id_site" id="id_site" value="<?= $site->getIdSite() ?>" readonly><br>

    <label for="nom">Nom du site</label>
    <input type="text" name="nom" id="nom" value="<?= $site->getNom() ?>" required><br>

    <label for="adresse">Adresse</label>
    <input type="text" name="adresse" id="adresse" value="<?= $site->getAdresse() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabSite.php">Annuler</a>
</form>
</body>
</html>
