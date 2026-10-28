<?php
require_once "../bdd/bdd.php";
require_once "../src/model/Offre.php";
require_once "../src/repository/OffreRepository.php";

$offreRepository = new OffreRepository();
$offres = $offreRepository->getAllOffres();

function h($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

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
            + Publier une offre
        </button>
    </div>
</header>

<main class="container mt-4">

    <!-- addModal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="eyebrow">Ajouter une offre</div>
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
                            <label class="form-label">Salaire (€/mois)</label>
                            <input type="number" class="form-event" name="salaire" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type d'offre</label>
                            <select class="form-event" name="type_offre" required>
                                <option value="Stage">Stage</option>
                                <option value="Alternance">Alternance</option>
                                <option value="Job étudiant">Job étudiant</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">État</label>
                            <select class="form-event" name="etat" required>
                                <option value="0">Ouvert</option>
                                <option value="1">Fermé</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Entreprise</label>
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

    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="box mb-3">
                <h6>
                    Affiner ma recherche
                </h6>
                <label class="form-label small-t">
                    Type d'offre
                </label>
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
                <label class="form-label small-t mt-3">
                    État
                </label>
                <select class="form-select form-select-sm mb-3">
                    <option>
                        Ouverte
                    </option>
                    <option>
                        Fermée
                    </option>
                </select>
                <label class="form-label small-t">
                    Entreprise
                </label>
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
            <h5>
                Offres disponibles
            </h5>

            <?php if (empty($offres)): ?>
                <p class="muted">Aucune offre pour le moment.</p>
            <?php endif; ?>

            <?php foreach ($offres as $id => $offre): ?>
                <?php
                // 0 = Ouvert, 1 = Fermé (comme dans le formulaire d'ajout)
                $ferme = ((int)$offre->getEtat() === 1);
                ?>

                <!-- Ligne large -->
                <div class="row-i ev">
                    <?php if ($ferme): ?>
                        <div class="logo-sq-complet">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    <?php else: ?>
                        <div class="logo-sq">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    <?php endif; ?>
                    <div class="flex-grow-1">
                        <b><?= ($offre->getTitre()) ?></b>
                        <div class="muted small-t">
                            Agence Lumière · Paris · <?= ($offre->getSalaire()) ?> €/mois
                        </div>
                        <p class="muted small-t my-1"><?= ($offre->getMission()) ?></p>
                        <span class="tag"><?= ($offre->getTypeOffre()) ?></span>
                        <?php if ($ferme): ?>
                            <span class="tag" style="background:#fde8e8;color:#c0392b">Fermé</span>
                        <?php else: ?>
                            <span class="tag">Ouvert</span>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <?php if (!$ferme): ?>
                            <a class="btn btn-sm btn-primary" href="#">Postuler</a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                            Aperçu
                        </button>
                        <?php if (!$ferme): ?>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#edit<?= $id ?>">
                                Modifier
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- previewModal -->
                <div class="modal fade preview-modal" id="preview<?= $id ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="eyebrow">Aperçu de l'offre</div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="mb-3"><?= ($offre->getTitre()) ?></h5>

                                <div class="mb-3">
                                    <div class="form-label">Mission</div>
                                    <div><?= ($offre->getMission()) ?></div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-label">Salaire</div>
                                    <div><?= ($offre->getSalaire()) ?> €/mois</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-label">Type d'offre</div>
                                    <div><?= ($offre->getTypeOffre()) ?></div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-label">État</div>
                                    <div><?= $ferme ? 'Fermé' : 'Ouvert' ?></div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-label">Description</div>
                                    <p class="mb-0"><?= h($offre->getDescription()) ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <form method="POST" action="../src/traitement/suppOffre.php">
                                    <input type="hidden" name="id_offre" value="<?= h($offre->getIdOffre()) ?>">
                                    <input type="hidden" name="titre" value="<?= h($offre->getTitre()) ?>">
                                    <button class="btn btn-danger btn-sm mt-2">
                                        Supprimer
                                    </button>
                                </form>
                                <?php if (!$ferme): ?>
                                    <a href="#" class="btn btn-primary">Postuler</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>