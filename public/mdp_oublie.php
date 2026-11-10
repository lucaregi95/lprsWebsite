<?php
require_once __DIR__ . "/../bdd/bdd.php";
require_once __DIR__ . "/../src/repository/UtilisateurRepository.php";
require_once __DIR__ . "/../src/service/MailService.php";

$message = null;
$erreur  = null;

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $rep  = new UtilisateurRepository();
    $user = $rep->existeEmail($email);

    if (!$user) {
        $erreur = "Aucun compte n'est associé à cette adresse e-mail.";
    } elseif ($user['statut_validation'] === 'banni') {
        $erreur = "Ce compte est suspendu, contacte un gestionnaire.";
    } else {
        $token      = bin2hex(random_bytes(32));          // token en clair, envoyé par mail
        $hash       = hash('sha256', $token);             // hash stocké en base
        $expiration = date('Y-m-d H:i:s', time() + 3600); // valable 1 heure

        $rep->setResetToken($user['id_utilisateur'], $hash, $expiration);

        $lien = "http://localhost/lprsWebsite/public/reset_mdp.php?token=" . $token;

        $ok = MailService::envoyer(
                $email,
                "Réinitialisation de ton mot de passe LPRS",
                "<p>Bonjour,</p>
             <p>Pour choisir un nouveau mot de passe, clique sur ce lien :</p>
             <p><a href='" . $lien . "'>Réinitialiser mon mot de passe</a></p>
             <p>Ce lien est valable 1 heure. Si tu n'es pas à l'origine de cette demande, ignore ce mail.</p>"
        );

        if ($ok) {
            $message = "Un mail contenant le lien de réinitialisation vient d'être envoyé. Pensez a verifier vos spams ";
        } else {
            $erreur = "L'envoi du mail a échoué, réessaie plus tard.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>LPRS - Mot de passe oublié</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
</head>
<body class="body_connexion">
<div class="auth-wrapper">
    <div class="auth">
        <div class="p-4">
            <div class="auth-form">
                <h4 class="fw-bold text-center">Mot de passe oublié</h4>
                <p class="muted small-t text-center">Renseigne ton adresse e-mail pour recevoir un lien.</p>

                <?php if ($message) { ?>
                    <div class="alert alert-success small"><?= htmlspecialchars($message) ?></div>
                <?php } ?>
                <?php if ($erreur) { ?>
                    <div class="alert alert-danger small"><?= htmlspecialchars($erreur) ?></div>
                <?php } ?>

                <form method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="email">Adresse e-mail :</label>
                        <input class="form-control form-control-sm" type="email" id="email" name="email" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Envoyer le lien</button>
                </form>

                <p class="small-t text-center mt-3 mb-0"><a href="connexion.php">Retour à la connexion</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>