<?php
require_once __DIR__ . "/../bdd/bdd.php";
require_once __DIR__ . "/../src/repository/UtilisateurRepository.php";

$token = $_GET['token'] ?? $_POST['token'] ?? '';
$rep   = new UtilisateurRepository();
$user  = ($token !== '') ? $rep->getUtilisateurByToken(hash('sha256', $token)) : false;

if (!$user) {
    exit("Lien invalide ou expiré.");
}

$erreur = null;

if (isset($_POST['mdp'], $_POST['mdp2'])) {
    if (strlen($_POST['mdp']) < 8) {
        $erreur = "Le mot de passe doit faire au moins 8 caractères.";
    } elseif ($_POST['mdp'] !== $_POST['mdp2']) {
        $erreur = "Les deux mots de passe ne correspondent pas.";
    } else {
        $rep->updateTokenEtMDP($user['id_utilisateur'], password_hash($_POST['mdp'], PASSWORD_DEFAULT));
        header('Location: connexion.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>LPRS - Nouveau mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
</head>
<body class="body_connexion">
<div class="auth-wrapper">
    <div class="auth">
        <div class="p-4">
            <div class="auth-form">
                <h4 class="fw-bold text-center">Nouveau mot de passe</h4>

                <?php if ($erreur) { ?>
                    <div class="alert alert-danger small"><?= htmlspecialchars($erreur) ?></div>
                <?php } ?>

                <form method="POST" autocomplete="off">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="mb-3">
                        <label for="mdp">Nouveau mot de passe :</label>
                        <input class="form-control form-control-sm" type="password" id="mdp" name="mdp" autocomplete="new-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp2">Confirmer :</label>
                        <input class="form-control form-control-sm" type="password" id="mdp2" name="mdp2" autocomplete="new-password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Valider</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>