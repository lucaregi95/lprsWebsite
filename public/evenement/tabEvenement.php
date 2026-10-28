<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/EvenementRepository.php";

$evenementRepository = new EvenementRepository();
$evenements = $evenementRepository->getAllEvenements();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Evenements</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Description</th>
        <th>Lieu</th>
        <th>Nombre de place</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($evenements as $evenement) { ?>
        <tr>
            <td><?= $evenement->getIdEvenement() ?></td>
            <td><?= $evenement->getTitre() ?></td>
            <td><?= $evenement->getDescription() ?></td>
            <td><?= $evenement->getLieu() ?></td>
            <td><?= $evenement->getNbrPlaces() ?></td>
            <td><a href="modifierEvenement.php?id=<?= $evenement    ->getIdEvenement() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerEvenement.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l evenement  n°<?= $evenement->getIdEvenement() ?> ?');">
                    <input type="hidden" name="id_evenement" value="<?= $evenement->getIdEvenement() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="../evenement.php">Ajouter un evenement</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
