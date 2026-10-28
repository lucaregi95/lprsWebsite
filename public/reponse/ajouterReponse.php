<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newReponse.php';
require_once __DIR__ . '/../../src/repository/ReponseRepository.php';

if (isset($reponse)) {
    $reponseRepository = new ReponseRepository();
    $reponseRepository->ajouterReponse($reponse);
    header('Location: tabReponse.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un reponse</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1>Ajouter un reponse</h1>

<form action="ajouterReponse.php" method="post">
    <label for="contenu">Contenu</label>
    <input type="text" name="contenu" id="contenu" required><br>

    <label for="datetime_reponse">Date et heure</label>
    <input type="date" name="datetime_reponse" id="datetime_reponse" required><br>

    <label for="ref_utilisateur">Utilisateur</label>
    <input type="number" name="ref_utilisateur" id="ref_utilisateur" required><br>

    <label for="ref_post">Post</label>
    <input type="number" name="ref_post" id="ref_post" required><br>

    <button type="submit">Valider</button>
    <a href="tabReponse.php">Retour</a>
</form>

</body>
</html>
