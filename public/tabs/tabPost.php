<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/PostRepository.php";

$postRepository = new PostRepository();
$posts = $postRepository->getAllPosts();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Contenu</th>
        <th>Posté le </th>
        <th>Par</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post) { ?>
        <tr>
            <td><?= $post->getIdPost() ?></td>
            <td><?= $post->getContenu() ?></td>
            <td><?= $post->getDatePost() ?></td>
            <td><?= $post->getRefUtilisateur() ?></td>
            <td><a href="modifierPost.php?id=<?= $posts->getIdPost() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerPost.php" onsubmit="return confirm('Voulez-vous vraiment supprimer le post  n°<?= $post->getIdPost() ?> ?');">
                    <input type="hidden" name="id_site" value="<?= $post->getIdPost() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterPost.php">Ajouter un post</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
