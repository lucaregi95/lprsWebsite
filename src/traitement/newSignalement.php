<?php
require_once "../../bdd/Bdd.php";
require_once "../model/Signalement.php";

if(isset($_POST['date']) && isset($_POST['ref_signalant']) && isset($_POST['ref_signale']) && isset($_POST['titre'])&& isset($_POST['contenu'])){
    $id_signalement = (isset($_POST['id_signalement'])) ? $_POST['id_signalement'] : null;


    $signalement = new Signalement($id_signalement,$_POST['date'],$_POST['contenu'],$_POST['titre'],$_POST['ref_signalant'],$_POST['ref_signale']);
}