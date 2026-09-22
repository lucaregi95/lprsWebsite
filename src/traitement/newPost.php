<?php

require_once "../bdd/bdd.php";
require_once "../model/Post.php";

if(isset($_POST['contenu']) && isset($_POST['date']) && isset($_POST['heure'])){
    $id_post = (isset($_POST['id_post'])) ? $_POST['id_post'] : null;


    $post = new Post($id_post,$_POST["contenu"],$_POST["date"],$_POST["heure"]);
}
