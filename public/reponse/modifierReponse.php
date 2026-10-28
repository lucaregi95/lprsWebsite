<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/ReponseRepository.php';

$reponseRepository = new ReponseRepository();

if (isset($_POST['btn_submit'])) {
    $reponse = new Reponse(
        $_POST['id_reponse'],
        $_POST['contenu'],
        $_POST['datetime_reponse'],
        $_POST['ref_utilisateur'],
        $_POST['ref_post']
    );
    $reponseRepository->modifierReponse($reponse);
    header('Location: tabReponse.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabReponse.php');
    exit;
}

$reponse = $reponseRepository->getReponse($_GET['id']);
if (!$reponse) {
    header('Location: tabReponse.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un reponse</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<h1>Modifier le reponse</h1>

<form method="post" action="modifierReponse.php">
    <label for="id_reponse">ID</label>
    <input type="text" name="id_reponse" id="id_reponse" value="<?= $reponse->getIdReponse() ?>" readonly><br>

    <label for="contenu">Contenu</label>
    <input type="text" name="contenu" id="contenu" value="<?= $reponse->getContenu() ?>" required><br>

    <label for="datetime_reponse">Date et Heure de la reponse</label>
    <input type="text" name="datetime_reponse" id="datetime_reponse" value="<?= $reponse->getDatetimeReponse() ?>" required><br>

    <label for="ref_utilisateur">Utilisateur</label>
    <input type="text" name="ref_utilisateur" id="ref_utilisateur" value="<?= $reponse->getRefUtilisateur() ?>" required><br>

    <label for="ref_post">Post</label>
    <input type="text" name="ref_post" id="ref_post" value="<?= $reponse->getRefPost() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabReponse.php">Annuler</a>
</form>
</body>
</html>
