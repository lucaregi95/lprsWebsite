<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../bdd/bdd.php';
require_once __DIR__ . '/../../src/model/Promotion.php';
require_once __DIR__ . '/../../src/repository/PromotionRepository.php';

$promotionRepository = new PromotionRepository();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_promotion'])) {
    $promotion = $promotionRepository->getPromotion($_POST['id_promotion']);
    if ($promotion) {
        $promotionRepository->supprimerPromotion($_POST['id_promotion']);
    }
}

header('Location: tabPromotion.php');
exit;