<?php
session_start();
require_once "../../bdd/bdd.php";
require_once "../model/Post.php";
require_once "../repository/PostRepository.php"; // adapte le chemin

if (!isset($_SESSION['id_utilisateur'])) {
    header("location:../../public/connexion.php?page=f");
    exit();
}

if (isset($_POST['contenu'], $_POST['categorie_post'], $_POST['titre'])) {
    $post = new Post(
        null,
        $_POST['contenu'],
        date('Y-m-d H:i:s'),
        $_POST['titre'],
        $_POST['categorie_post'],
        $_SESSION['id_utilisateur']
    );

    (new PostRepository())->ajouterPost($post);
}

header("location:../../public/forum.php");
exit();