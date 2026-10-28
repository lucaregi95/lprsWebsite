<?php
require_once "../bdd/bdd.php";
require_once "../src/model/Offre.php";
require_once "../src/repository/OffreRepository.php";

$offreRepository = new OffreRepository();
$offres = $offreRepository->getAllOffres();

?>
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
            <a class="nav-link" href="inscription.php">Inscription --</a>
            <a class="nav-link" href="connexion.php">-- Connexion</a>
            <!--            <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="profil.php">-->
            <!--                <span class="avatar">NK</span>-->
            <!--                <span class="small">Nassim K. <i class="bi bi-chevron-down"></i></span>-->
            <!--            </a>-->
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            + Publier une Offre
        </button>
    </div>
</header>


<main class="container mt-4">

    <!--/* aperçuModal */   -->

<!--/* addModal */   -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="eyebrow">Ajouter une Offre</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="../src/traitement/newOffre.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'offre</label>
                            <input type="text" class="form-event" name="titre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-event" id="description" name="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mission</label>
                            <input type="text" class="form-event" name="mission" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salaire</label>
                            <input type="number" class="form-event" name="salaire" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type d'offre</label>
                            <input type="text" class="form-event" name="type_offre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Etat:</label>
                            <select class="form-event" name="etat" required>
                                <option value="ouvert">Ouvert</option>
                                <option value="ferme">Fermé</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Entreprise:</label>
                            <select class="form-event" name="ref_entreprise" required>
                                <option value="1">A</option>
                                <option value="2">B</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--/* modifModal */   -->
<!--/* suppModal */   -->

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
            <?php if (empty($offres)): ?>
                <p class="muted">Aucune offre pour le moment.</p>
            <?php endif; ?>
            <?php foreach ($offres as $offre):  ?>
            <div class="row-i ev">
                <div class="logo-sq">
                    <i class="bi bi-briefcase">
                    </i>
                </div>
                <div class="flex-grow-1">
                    <b>
                        <?= $offre->getTitre() ?>
                    </b>
                    <div class="muted small-t">
                        Agence Lumière · Paris · <?= $offre->getSalaire() ?> €/mois
                    </div>
                    <p class="muted small-t my-1">
                        <?= $offre->getMission() ?>
                    </p>
                    <span class="tag">
                <?= $offre->getTypeOffre() ?>
              </span>
                    <span class="tag" style="">
                <?= $offre->getEtat() ?>
              </span>
                </div>
                <a class="btn btn-sm btn-primary" href="#">
                    Postuler
                </a>
            </div>
            <?php endforeach; ?>
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