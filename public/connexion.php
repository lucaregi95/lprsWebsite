<?php


ini_set('display_errors', 5);
error_reporting(E_ALL);

$bdd = null;
require_once('../bdd/bdd.php');

$nom=null;
$prenom=null;
$email=null;
if(isset($_POST['email'])){
    $email=$_POST['email'];
}
$erreur=null;
$inscription=null;
if(isset($_GET['erreur'])){
    if ($_GET['erreur']=='unknown'){
        $erreur="Identifiants inexistants";
    }
    if ($_GET['erreur']=='incorrect'){
        $erreur="Identifiants incorrects";
    }

}

if(isset($_GET['page'])){
    $page=$_GET['page'];

}
$inscription="Pas de compte ? Inscrivez-vous";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        Campus - Connexion
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>

</head>
<body class="body_connexion">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="accueil.php">
            <img class="logo" src="img/logo.png">
        </a>
        <button class="navbar-toggler" data-bs-target="#m" data-bs-toggle="collapse">
          <span class="navbar-toggler-icon">
          </span>
        </button>
        <div class="collapse navbar-collapse" id="m">
            <ul class="navbar-nav ms-4 me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="accueil.php">
                        Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="evenement.php">
                        Évènement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="offre.php">
                        Offre
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum.php">
                        Forum
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-5">
    <div class="auth-wrapper">
        <div class="auth">
            <div class="p-4 p-lg-4">
                <div class="auth-form">
                    <h4 class="fw-bold text-center">Connexion</h4>
                    <p class="muted small-t text-center">Renseigne tes informations.</p>

                    <form method="POST" action="connexion2.php">
                        <div class="mb-3">
                        <label for="email">Adresse e-mail :</label>
                        <input class="form-control form-control-sm" type="email" id="email" name="email" value="<?=$email?>" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                        <label for="mdp">Mot de Passe :</label>
                        <input class="form-control form-control-sm" type="password" id="mdp" name="mdp" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                        <?php if (isset($page)) {?>
                            <input class="form-control form-control-sm" type="hidden" value="<?=$page?>" name="page">
                        <?php } ?>
                        <h6><?=$erreur?></h6>
                        </div>

                        <button class="btn btn-primary w-100"  type="submit">Connectez-vous !</button>
                    </form>

                    <p class="small-t text-center mt-3 mb-0">
                        Pas encore de compte ?
                    <div class="small-t text-center mt-3 mb-0">
                        <a style="text-align: center !important;" href="inscription.php"><?=$inscription?></a>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div>
        <div>
            <h4>Nous contacter</h4>

            <a href="https://mail.google.com/mail/?view=cm&to=LPRS@gmail.com&su=Prise de contact"
               target="_blank">LPRS@gmail.com</a>
        </div>
    </div>
    <div>
        <p>© 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn, William Lemaire — Tous droits réservés</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>