<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/ReponseRepository.php";

$reponseRepository = new ReponseRepository();
$reponses = $reponseRepository->getAllReponses();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reponses</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Contenu</th>
        <th>Posté le</th>
        <th>Par</th>
        <th>Reponse au post n°</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reponses as $reponse) { ?>
        <tr>
            <td><?= $reponse->getIdReponse() ?></td>
            <td><?= $reponse->getContenu() ?></td>
            <td><?= $reponse->getDatetimeReponse() ?></td>
            <td><?= $reponse->getRefUtilisateur() ?></td>
            <td><?= $reponse->getRefPost() ?></td>
            <td><a href="modifierReponse.php?id=<?= $reponse->getIdReponse() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerReponse.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l reponse  n°<?= $reponse->getIdReponse() ?> ?');">
                    <input type="hidden" name="id_reponse" value="<?= $reponse->getIdReponse() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterReponse.php">Ajouter un reponse</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
