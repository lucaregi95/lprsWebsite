<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/EvenementRepository.php';

$evenementRepository = new EvenementRepository();

if (isset($_POST['btn_submit'])) {
    $evenement = new Evenement(
        $_POST['id_evenement'],
        $_POST['titre'],
        $_POST['description'],
        $_POST['lieu'],
        $_POST['nbr_places']
    );
    $evenementRepository->modifierEvenement($evenement);
    header('Location: tabEvenement.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabEvenement.php');
    exit;
}

$evenement = $evenementRepository->getEvenement($_GET['id']);
if (!$evenement) {
    header('Location: tabEvenement.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un evenement</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le evenement</h1>

<form method="post" action="modifierEvenement.php">
    <label for="id_evenement">ID</label>
    <input type="text" name="id_evenement" id="id_evenement" value="<?= $evenement->getIdEvenement() ?>" readonly><br>

    <label for="titre">Titre de l'evenement</label>
    <input type="text" name="titre" id="titre" value="<?= $evenement->getTitre() ?>" required><br>

    <label for="description">Descritpion</label>
    <input type="text" name="description" id="description" value="<?= $evenement->getDescription() ?>" required><br>

    <label for="lieu">Lieu</label>
    <input type="text" name="lieu" id="lieu" value="<?= $evenement->getLieu() ?>" required><br>

    <label for="nbr_places">Nombre de places</label>
    <input type="text" name="nbr_places" id="nbr_places" value="<?= $evenement->getNbrPlaces() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabEvenement.php">Annuler</a>
</form>
</body>
</html>
