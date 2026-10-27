<?php

require_once "../../bdd/bdd.php";
require_once "../model/Post.php";

if(isset($_POST['contenu']) && isset($_POST['date_post']) && isset($_POST['categorie_post']) && isset($_POST['titre']) && isset($_POST['ref_utilisateur'])){
    $id_post = (isset($_POST['id_post'])) ? $_POST['id_post'] : null;


    $post = new Post($id_post,$_POST["contenu"],$_POST["date_post"],$_POST["titre"],$_POST["categorie_post"],$_POST["ref_utilisateur"]);
}
