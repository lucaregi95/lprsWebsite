<?php
 ini_set('display_errors', 1);
 error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/EntrepriseRepository.php";

$entrepriseRepository = new EntrepriseRepository();
$entreprises = $entrepriseRepository->getAllEntreprises();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Entreprises</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Adresse</th>
        <th>Nom de l'entreprise</th>
        <th>Site Web</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($entreprises as $entreprise) { ?>
        <tr>
            <td><?= $entreprise->getIdEntreprise() ?></td>
            <td><?= $entreprise->getAdresse() ?></td>
            <td><?= $entreprise->getNomEntreprise() ?></td>
            <td><?= $entreprise->getSiteWeb() ?></td>
            <td><a href="modifierEntreprise .php?id=<?= $entreprise->getIdEntreprise() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerEntreprise.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l entreprise  n°<?= $entreprise->getIdEntreprise() ?> ?');">
                    <input type="hidden" name="id_site" value="<?= $entreprise->getIdEntreprise() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="ajouterEntreprise.php">Ajouter une entreprise</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
