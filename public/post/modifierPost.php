<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/PostRepository.php';

$postRepository = new PostRepository();

if (isset($_POST['btn_submit'])) {
    $post = new Post(
        $_POST['id_post'],
        $_POST['contenu'],
        $_POST['date_post'],
        $_POST['ref_utilisateur'],
        $_POST['categorie_post'],
        $_POST['titre'],
    );
    $postRepository->modifierPost($post);
    header('Location: tabPost.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabPost.php');
    exit;
}

$post = $postRepository->getPost($_GET['id']);
if (!$post) {
    header('Location: tabPost.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un post</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<h1>Modifier le post</h1>

<form method="post" action="modifierPost.php">
    <label for="id_post">ID</label>
    <input type="text" name="id_post" id="id_post" value="<?= $post->getIdPost() ?>" readonly><br>

    <label for="contenu">Contenu</label>
    <input type="text" name="contenu" id="contenu" value="<?= $post->getContenu() ?>" required><br>

    <label for="date_post">Date</label>
    <input type="text" name="date_post" id="date_post" value="<?= $post->getDatePost() ?>" required><br>

    <label for="ref_utilisateur">Utilisateur</label>
    <input type="text" name="ref_utilisateur" id="ref_utilisateur" value="<?= $post->getRefUtilisateur() ?>" required><br>

    <label for="categorie_post">Categorie</label>
    <input type="text" name="categorie_post" id="categorie_post" value="<?= $post->getCategoriePost() ?>" required><br>

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre" value="<?= $post->getTitre() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabPost.php">Annuler</a>
</form>
</body>
</html>
