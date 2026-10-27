<?php?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        Campus - Offre
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
</head>
<body>
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
            <i class="bi bi-search me-3">
            </i>
            <i class="bi bi-bell me-3">
            </i>
            <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="profil.php">
            <span class="avatar">
              ML
            </span>
                <span class="small">
              Marie L.
              <i class="bi bi-chevron-down">
              </i>
            </span>
            </a>
        </div>
    </div>
</nav>
<header class="hero">
    <div class="container d-flex justify-content-between align-items-end">
        <div>
            <div class="eyebrow">
                Campus · Offres
            </div>
            <h1>
                Offre
            </h1>
            <p>
                Stages, alternances et jobs étudiants proposés par nos entreprises.
            </p>
        </div>
        <a class="btn btn-primary" href="#">
            + Publier une offre
        </a>
    </div>
</header>
<main class="container mt-4">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="box mb-3">
                <h6>
                    Type d'offre
                </h6>
                <div class="form-check small-t">
                    <input checked="" class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Tous les types
                    </label>
                </div>
                <div class="form-check small-t">
                    <input class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Stage
                    </label>
                </div>
                <div class="form-check small-t">
                    <input class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Alternance
                    </label>
                </div>
                <div class="form-check small-t">
                    <input class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Job étudiant
                    </label>
                </div>
                <h6 class="mt-3">
                    État
                </h6>
                <select class="form-select form-select-sm">
                    <option>
                        Ouverte
                    </option>
                    <option>
                        Fermée
                    </option>
                </select>
                <h6 class="mt-3">
                    Entreprise
                </h6>
                <select class="form-select form-select-sm">
                    <option>
                        Toutes
                    </option>
                    <option>
                        Agence Lumière
                    </option>
                    <option>
                        Studio Nord
                    </option>
                    <option>
                        DataCorp
                    </option>
                </select>
            </div>
            <div class="promo">
                <b class="small-t">
                    Mes candidatures
                </b>
                <p class="muted small-t mb-0">
                    2 offres auxquelles tu as postulé.
                </p>
            </div>
        </aside>
        <div class="col-lg-9">
            <div class="d-flex gap-2 mb-3">
                <input class="form-control form-control-sm" placeholder="Rechercher une offre"/>
                <select class="form-select form-select-sm w-auto">
                    <option>
                        Plus récentes
                    </option>
                </select>
            </div>
            <div class="row-i ev">
                <div class="logo-sq">
                    <i class="bi bi-briefcase">
                    </i>
                </div>
                <div class="flex-grow-1">
                    <b>
                        Stage assistant communication
                    </b>
                    <div class="muted small-t">
                        Agence Lumière · Paris · 1 200 €/mois
                    </div>
                    <p class="muted small-t my-1">
                        Gestion des réseaux sociaux et création de contenus.
                    </p>
                    <span class="tag">
                Stage
              </span>
                    <span class="tag" style="">
                Ouverte
              </span>
                </div>
                <a class="btn btn-sm btn-primary" href="#">
                    Postuler
                </a>
            </div>
            <div class="row-i ev">
                <div class="logo-sq">
                    <i class="bi bi-briefcase">
                    </i>
                </div>
                <div class="flex-grow-1">
                    <b>
                        Alternance développeur web
                    </b>
                    <div class="muted small-t">
                        Studio Nord · Lyon · 1 450 €/mois
                    </div>
                    <p class="muted small-t my-1">
                        Développement front-end et maintenance d'applications.
                    </p>
                    <span class="tag">
                Alternance
              </span>
                    <span class="tag" style="">
                Ouverte
              </span>
                </div>
                <a class="btn btn-sm btn-primary" href="#">
                    Postuler
                </a>
            </div>
            <div class="row-i ev">
                <div class="logo-sq">
                    <i class="bi bi-briefcase">
                    </i>
                </div>
                <div class="flex-grow-1">
                    <b>
                        Stage data analyst
                    </b>
                    <div class="muted small-t">
                        DataCorp · Télétravail · 1 100 €/mois
                    </div>
                    <p class="muted small-t my-1">
                        Analyse de jeux de données et tableaux de bord.
                    </p>
                    <span class="tag">
                Stage
              </span>
                    <span class="tag" style="">
                Ouverte
              </span>
                </div>
                <a class="btn btn-sm btn-primary" href="#">
                    Postuler
                </a>
            </div>
            <div class="row-i ev">
                <div class="logo-sq">
                    <i class="bi bi-briefcase">
                    </i>
                </div>
                <div class="flex-grow-1">
                    <b>
                        Job étudiant accueil
                    </b>
                    <div class="muted small-t">
                        Agence Lumière · Paris · 12 €/h
                    </div>
                    <p class="muted small-t my-1">
                        Accueil des visiteurs et gestion du standard.
                    </p>
                    <span class="tag">
                Job étudiant
              </span>
                    <span class="tag" style="background:#fde8e8;color:#c0392b">
                Fermée
              </span>
                </div>
                <a class="btn btn-sm btn-primary disabled" href="#">
                    Postuler
                </a>
            </div>
            <ul class="pagination pagination-sm justify-content-center mt-3">
                <li class="page-item">
                    <a class="page-link" href="#">
                        ‹
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">
                        1
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        2
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        ›
                    </a>
                </li>
            </ul>
        </div>
    </div>
</main>
<footer>
    <div class="container d-flex flex-wrap justify-content-between">
        <b class="text-dark">
            campus
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
        © 2026 Campus. Tous droits réservés.
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>