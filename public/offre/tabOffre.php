<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/OffreRepository.php";

$offreRepository = new OffreRepository();
$offres = $offreRepository->getAllOffres();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Offres</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Description</th>
        <th>Mission</th>
        <th>Salaire</th>
        <th>Type</th>
        <th>Etat</th>
        <th>Entreprise</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($offres as $offre) { ?>
        <tr>
            <td><?= $offre->getIdOffre() ?></td>
            <td><?= $offre->getTitre() ?></td>
            <td><?= $offre->getDescription() ?></td>
            <td><?= $offre->getMission() ?></td>
            <td><?= $offre->getSalaire() ?></td>
            <td><?= $offre->getTypeOffre() ?></td>
            <td><?= $offre->getEtat() ?></td>
            <td><?= $offre->getRefEntreprise() ?></td>
            <td><a href="modifierOffre.php?id=<?= $offres->getIdOffre() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerOffre.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l offre  n°<?= $offre->getIdOffre() ?> ?');">
                    <input type="hidden" name="id_offre" value="<?= $offre->getIdOffre() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterOffre.php">Ajouter une offre</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
