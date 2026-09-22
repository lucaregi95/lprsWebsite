<?php

require_once "../bdd/bdd.php";
require_once "../model/Etudiant.php";


if (isset($_POST['cv']) && isset($_POST['ref_formation']) && isset($_POST['ref_promotion'])) {
    $ref_utilisateur = (isset($_POST['id_evenement'])) ? $_POST['id_evenement'] : null;


    $etudiant = new Etudiant($ref_utilisateur, $_POST['cv'], $_POST['ref_formation'], $_POST['ref_promotion']);
}



