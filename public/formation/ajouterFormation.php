<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newFormation.php';
require_once __DIR__ . '/../../src/repository/FormationRepository.php';

if (isset($formation)) {
    $formationRepository = new FormationRepository();
    $formationRepository->ajoutFormation($formation);
    header('Location: tabFormation.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une formation</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1>Ajouter une formation</h1>

<form action="ajouterFormation.php" method="post">
    <label for="nom_formation">Nom de la formation</label>
    <input type="text" name="nom_formation" id="nom_formation" required><br>

    <button type="submit">Valider</button>
    <a href="tabFormation.php">Retour</a>
</form>

</body>
</html>
