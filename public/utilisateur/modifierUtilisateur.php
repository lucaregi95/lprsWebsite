<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__ . '/../../src/repository/UtilisateurRepository.php';

$utilisateurRepository = new UtilisateurRepository();

if (isset($_POST['btn_submit'])) {
    $utilisateur = new Utilisateur(
        $_POST['id_utilisateur'],
        $_POST['nom'],
        $_POST['adresse']
    );
    $utilisateurRepository->modifierUtilisateur($utilisateur);
    header('Location: tabUtilisateur.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: tabUtilisateur.php');
    exit;
}

$utilisateur = $utilisateurRepository->getUtilisateur($_GET['id']);
if (!$utilisateur) {
    header('Location: tabUtilisateur.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>Modifier le utilisateur</h1>

<form method="post" action="modifierUtilisateur.php">
    <label for="id_utilisateur">ID</label>
    <input type="text" name="id_utilisateur" id="id_utilisateur" value="<?= $utilisateur->getIdUtilisateur() ?>" readonly><br>

    <label for="nom">Nom du utilisateur</label>
    <input type="text" name="nom" id="nom" value="<?= $utilisateur->getNom() ?>" required><br>

    <label for="adresse">Adresse</label>
    <input type="text" name="adresse" id="adresse" value="<?= $utilisateur->getAdresse() ?>" required><br>

    <input type="submit" name="btn_submit" value="Enregistrer">
    <a href="tabUtilisateur.php">Annuler</a>
</form>
</body>
</html>
