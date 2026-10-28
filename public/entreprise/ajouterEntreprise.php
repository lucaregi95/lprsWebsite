<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newEntreprise.php';
require_once __DIR__ . '/../../src/repository/EntrepriseRepository.php';

if (isset($entreprise)) {
    $entrepriseRepository = new EntrepriseRepository();
    $entrepriseRepository->ajoutEntreprise($entreprise);
    header('Location: tabEntreprise.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une entreprise</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1>Ajouter une entreprise</h1>

<form action="ajouterEntreprise.php" method="post">
    <label for="adresse">Adresse de l'entreprise</label>
    <input type="text" name="adresse" id="adresse" required><br>

    <label for="nom_entreprise">Nom de l'entreprise</label>
    <input type="text" name="nom_entreprise" id="nom_entreprise" required><br>

    <label for="site_web">Site web de l'entreprise</label>
    <input type="url" name="site_web" id="site_web" required><br>

    <button type="submit">Valider</button>
    <a href="tabEntreprise.php">Retour</a>
</form>

</body>
</html>
