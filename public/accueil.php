<?php
session_start();
var_dump($_SESSION);
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
                <li class="nav-item"><a class="nav-link" href="alumni.php">Alumni</a></li>
                <li class="nav-item"><a class="nav-link" href="entreprise.php">Entreprises</a></li>
                <li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>
            </ul>


            <?php if(isset($_SESSION["id"])){ ?>
            <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="profil.php">
                <span class="avatar">NK</span>
                <span class="small"><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]?><i class="bi bi-chevron-down"></i></span>
           </a>
            <?php }else{ ?>
                <a class="nav-link" href="inscription.php">Inscription --</a>
                <a class="nav-link" href="connexion.php">-- Connexion</a>
            <?php } ?>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="eyebrow">LPRS · Accueil</div>
        <h1>Bonjour Nassim, bienvenue chez toi.</h1>
        <p>Étudiants, alumni, professeurs et entreprises réunis dans un même espace.</p>
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