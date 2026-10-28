<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/FormationRepository.php';

$formationRepository = new FormationRepository();

if (isset($_POST['btn_submit'])) {
    $formation = new Formation(
        $_POST['id_formation'],
        $_POST['nom_formation'],
    );
    $formationRepository->modifierFormation($formation);
    header('Location: tabFormation.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabFormation.php');
    exit;
}

$formation = $formationRepository->getFormation($_GET['id']);
if (!$formation) {
    header('Location: tabFormation.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un formation</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le formation</h1>

<form method="post" action="modifierFormation.php">
    <label for="id_formation">ID</label>
    <input type="text" name="id_formation" id="id_formation" value="<?= $formation->getIdFormation() ?>" readonly><br>

    <label for="nom_formation">Nom du formation</label>
    <input type="text" name="nom_formation" id="nom_formation" value="<?= $formation->getNomFormation() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabFormation.php">Annuler</a>
</form>
</body>
</html>
