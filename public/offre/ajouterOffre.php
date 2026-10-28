<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newOffre.php';
require_once __DIR__ . '/../../src/repository/OffreRepository.php';

if (isset($offre)) {
    $offreRepository = new OffreRepository();
    $offreRepository->ajoutOffre($offre);
    header('Location: tabOffre.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un offre</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1>Ajouter une offre</h1>

<form action="ajouterOffre.php" method="post">
    <label for="titre">Titre de l'offre</label>
    <input type="text" name="titre" id="titre" required><br>

    <label for="description">Description</label>
    <input type="text" name="description" id="description" required><br>

    <label for="mission">Mission</label>
    <input type="text" name="mission" id="mission" required><br>

    <label for="salaire">Salaire</label>
    <input type="text" name="salaire" id="salaire" required><br>

    <label for="type_offre">Type de l'offre</label>
    <input type="text" name="type_offre" id="type_offre" required><br>

    <label for="etat">Etat</label>
    <input type="text" name="etat" id="etat" required><br>

    <label for="ref_entreprise">Entreprise</label>
    <input type="text" name="ref_entreprise" id="ref_entreprise" required><br>

    <button type="submit">Valider</button>
    <a href="tabOffre.php">Retour</a>
</form>

</body>
</html>
