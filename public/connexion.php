<?php?>
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
    <link href="style.css" rel="stylesheet"/>
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

                    <form>
                        <div class="mb-3">
                            <label class="form-label small-t">Adresse e-mail</label>
                            <input class="form-control form-control-sm" type="email" value=""/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small-t">Mot de passe</label>
                            <input class="form-control form-control-sm" type="password" value=""/>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small-t">
                        <span class="form-check">
                            <input class="form-check-input" type="checkbox"/>
                            Se souvenir de moi
                        </span>
                            <a href="#">Mot de passe oublié ?</a>
                        </div>
                        <button class="btn btn-primary w-100" type="button">Se connecter</button>
                    </form>

                    <p class="small-t text-center mt-3 mb-0">
                        Pas encore de compte ?
                        <a href="inscription.php">Créer un compte maintenant</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="container d-flex flex-wrap justify-content-between">
        <b class="text-dark">
            LPRS
        </b>
        <div>
            <a href="#">
                Aide
            </a>
            <a href="#">
                Règles de la communauté
            </a>
            <a href="#">
                Mentions légales
            </a>
            <a href="#">
                Confidentialité
            </a>
        </div>
    </div>
    <div class="container mt-2">
        © 2026 LPRS. Tous droits réservés.
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
