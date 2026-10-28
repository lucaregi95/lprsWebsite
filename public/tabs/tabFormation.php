<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/FormationRepository.php";

$formationRepository = new FormationRepository();
$formations = $formationRepository->getAllFormations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formations</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($formations as $formation) { ?>
        <tr>
            <td><?= $formation->getIdFormation() ?></td>
            <td><?= $formation->getNomFormation() ?></td>
            <td><a href="modiferFormation.php?id=<?= $formations->getIdFormation() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerFormation.php" onsubmit="return confirm('Voulez-vous vraiment supprimer la formation  n°<?= $formations->getIdFormation() ?> ?');">
                    <input type="hidden" name="id_formation" value="<?= $formations->getIdFormation() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterFormation.php">Ajouter une formation</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
