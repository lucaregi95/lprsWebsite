<?php
require_once "../src/model/post.php";
require_once "../src/repository/postRepository.php";
require_once "../bdd/bdd.php";
require_once "forum.php"


if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();
}

$bdd = new Bdd();





?>