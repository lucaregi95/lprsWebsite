<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newPromotion.php';
require_once __DIR__ . '/../../src/repository/PromotionRepository.php';

if (isset($promotion)) {
    $promotionRepository = new PromotionRepository();
    $promotionRepository->ajoutPromotion($promotion);
    header('Location: tabPromotion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un promotion</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<h1>Ajouter un promotion</h1>

<form action="ajouterPromotion.php" method="post">
    <label for="annee">Annee</label>
    <input type="number" name="annee" id="annee" required><br>

    <button type="submit">Valider</button>
    <a href="tabPromotion.php">Retour</a>
</form>

</body>
</html>
