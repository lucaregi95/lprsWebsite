<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/PromotionRepository.php";

$promotionRepository = new PromotionRepository();
$promotions = $promotionRepository->getAllPromotions();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Promotions</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Année</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($promotions as $promotion) { ?>
        <tr>
            <td><?= $promotion->getIdPromotion() ?></td>
            <td><?= $promotion->getAnnee() ?></td>
            <td><a href="modifierPromotion.php?id=<?= $promotions->getIdPromotion() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerPromotion.php" onsubmit="return confirm('Voulez-vous vraiment supprimer la promotion  n°<?= $promotion->getIdPromotion() ?> ?');">
                    <input type="hidden" name="id_promotion" value="<?= $promotion->getIdPromotion() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterPromotion.php">Ajouter une promotion</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
