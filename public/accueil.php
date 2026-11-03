<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>LPRS - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="accueil.php">
            <img class="logo" src="img/logo.png" alt="LPRS">
        </a>
        <button class="navbar-toggler" data-bs-target="#m" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="m">
            <ul class="navbar-nav ms-4 me-auto">
                <li class="nav-item"><a class="nav-link active" href="accueil.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.php">Évènement</a></li>
                <li class="nav-item"><a class="nav-link" href="offre.php">Offre</a></li>
                <li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>
                <?php if(isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin') { ?>
                <li class="nav-item"><a class="nav-link" href="admin.php">Administration</a></li>
                <?php } ?>
            </ul>


            <?php if(isset($_SESSION["id_utilisateur"])){ ?>
                <div class="dropdown">
                    <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <span class="avatar"><?php echo $_SESSION["prenom"][0].$_SESSION["nom"][0] ?></span>
                        <span class="small"><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]." " ?><i class="bi bi-chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                        <li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
                    </ul>
                </div>
            <?php }else{ ?>
                <a class="nav-link" href="inscription.php">Inscription/</a>
                <a class="nav-link" href="connexion.php">Connexion</a>
            <?php } ?>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="eyebrow">LPRS · Accueil</div>
        <?php if(isset($_SESSION["id_utilisateur"])){?>
        <h1>Bonjour <?=$_SESSION["prenom"]?>, bienvenue sur ton espace LPRS.</h1>
        <?php }else{ ?>
        <h1>Créer votre compte ou connectez vous pour accéder a votre espace LPRS</h1>
        <?php }?>

        <p>Étudiants, alumni, professeurs et entreprises sont réunis sur une seule plateforme afin d'améliorer la circulation d'information à travers le lycée.</p>
    </div>
</header>


<footer>
    <div class="container d-flex flex-wrap justify-content-between">
        <b class="foot-brand">LPRS</b>
        <div>
            <a href="#">Aide</a>
            <a href="#">Règles de la communauté</a>
            <a href="#">Mentions légales</a>
            <a href="#">Confidentialité</a>
        </div>
    </div>
    <div class="container mt-2">© 2026 LPRS. Tous droits réservés.</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>