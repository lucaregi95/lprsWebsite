<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../src/repository/AlumniRepository.php";
require_once __DIR__ . "/../../src/repository/EtudiantRepository.php";
require_once __DIR__ . "/../../src/repository/PartenaireRepository.php";
require_once __DIR__ . "/../../src/repository/ProfesseurRepository.php";

$alumniRepository = new AlumniRepository();
$alumnis = $alumniRepository->getAllAlumnis();

$etudiantRepository = new EtudiantRepository();
$etudiants = $etudiantRepository->getAllEtudiants();

$partenaireRepository = new PartenaireRepository();
$partenaires = $partenaireRepository->getAllPartenaires();

$professeurRepository = new ProfesseurRepository();
$professeurs = $professeurRepository->getAllProfesseurs();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Statut Validation</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            <td><?= $utilisateur->getIdUtilisateur() ?></td>
            <td><?= $utilisateur->getNom() ?></td>
            <td><?= $utilisateur->getPrenom() ?></td>
            <td><?= $utilisateur->getEmail() ?></td>
            <td><?= $utilisateur->getStatutValidation() ?></td>
            <td><a href="modifierUtilisateur.php?id=<?= $utilisateur->getIdUtilisateur() ?>">Modifier</a></td>
            <td>
                <form method="post" action="supprimerUtilisateur.php" onsubmit="return confirm('Voulez-vous vraiment supprimer l utilisateur n°<?= $utilisateur->getIdUtilisateur() ?> ?');">
                    <input type="hidden" name="id_utilisateur" value="<?= $utilisateur->getIdUtilisateur() ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<a href="../inscription.php">Ajouter un utilisateur</a><br>
<button type="button" onclick="location.href='../accueil.html'">Retour à l'accueil</button>
</body>
</html>
