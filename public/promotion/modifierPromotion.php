<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/PromotionRepository.php';

$promotionRepository = new PromotionRepository();

if (isset($_POST['btn_submit'])) {
    $promotion = new Promotion(
        $_POST['id_promotion'],
        $_POST['annee'],
    );
    $promotionRepository->modifierPromotion($promotion);
    header('Location: tabPromotion.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabPromotion.php');
    exit;
}

$promotion = $promotionRepository->getPromotion($_GET['id']);
if (!$promotion) {
    header('Location: tabPromotion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un promotion</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<h1>Modifier le promotion</h1>

<form method="post" action="modifierPromotion.php">
    <label for="id_promotion">ID</label>
    <input type="number" name="id_promotion" id="id_promotion" value="<?= $promotion->getIdPromotion() ?>" readonly><br>

    <label for="annee">Annee</label>
    <input type="text" name="annee" id="annee" value="<?= $promotion->getAnnee() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabPromotion.php">Annuler</a>
</form>
</body>
</html>
