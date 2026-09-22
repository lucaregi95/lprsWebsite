<?php
require_once "../bdd/bdd.php";
require_once "../model/Promotion.php";
if(isset($_POST['annee'])) {
    $id_promotion = (isset($_POST['id_promotion'])) ? $_POST['id_promotion'] : null;
    $annee = (isset($_POST['annee'])) ? $_POST['annee'] : null;

    $promotion = new Promotion($id_promotion, $annee);
}

