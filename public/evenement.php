<?php

require_once "../bdd/bdd.php";
require_once "../src/model/Evenement.php";
require_once "../src/repository/EvenementRepository.php";

$eventRepository = new EvenementRepository();
$evenements = $eventRepository->getAllEvenements();
$inscrits = $eventRepository->getNbInscritsParEvenement();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        LPRS - Évènement
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
    <!-- dans le <head>, après style.css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
                    <a class="nav-link active" href="evenement.php">
                        Évènement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="offre.php">
                        Offre
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum.php">
                        Forum
                    </a>
                </li>
            </ul>
            <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="profil.php">
            <span class="avatar">
              NK
            </span>
                <span class="small">
              Nassim K.
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
                LPRS · Évènements
            </div>
            <h1>
                Évènement
            </h1>
            <p>
                Retrouve tous les évènements de LPRS.
            </p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            + Proposer un évènement
        </button>
    </div>
</header>
<main class="container mt-4">
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="eyebrow">Ajouter un évènement</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

                <form method="POST" action="../src/traitement/newEvenement.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom de l'évènement</label>
                            <input type="text" class="form-event" name="titre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-event" id="description" name="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lieu</label>
                            <input type="text" class="form-event" name="lieu" required>
                        </div>

                        <!-- Recherche + carte -->
                        <div class="mb-3">
                            <label class="form-label">Position exacte</label>
                            <div class="input-group mb-2">
                                <input type="text" id="recherche" class="form-control" placeholder="Tapez une adresse (ex : 10 rue de Rivoli, Paris)">
                                <button type="button" id="btnRecherche" class="btn btn-outline-secondary">Rechercher</button>
                            </div>
                            <div id="map" style="height:300px; width:100%;"></div>
                            <small class="text-muted">Vous pouvez aussi cliquer sur la carte pour ajuster le point.</small>
                            <input type="hidden" name="lat" id="lat">
                            <input type="hidden" name="lng" id="lng">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre de Place</label>
                            <input type="number" class="form-event" name="nbr_places" required>
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
                    Lieu
                </label>
                <select class="form-select form-select-sm mb-3">
                    <option>
                        Tous les lieux
                    </option>
                    <option>
                        Amphi A
                    </option>
                    <option>
                        Salle B12
                    </option>
                </select>
                <div class="form-check small-t">
                    <input checked="" class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Places disponibles uniquement
                    </label>
                </div>
                <div class="form-check small-t">
                    <input class="form-check-input" type="checkbox"/>
                    <label class="form-check-label">
                        Évènements que j'organise
                    </label>
                </div>
            </div>

        </aside>
        <div class="col-lg-9">
            <div class="d-flex gap-2 mb-3">
                <input class="form-control form-control-sm" placeholder="Rechercher un évènement"/>
                <select class="form-select form-select-sm w-auto">
                    <option>
                        Plus récents
                    </option>
                </select>
            </div>
            <h5>
                Évènements à venir
            </h5>
            <div class="row g-3">
                <?php if (empty($evenements)): ?>
                    <p class="muted">Aucun évènement pour le moment.</p>
                <?php endif; ?>
                <?php foreach ($evenements as $id => $evenement): ?>
                    <?php
                    $restantes = max(0, (int)$evenement->getNbrPlaces() - ($inscrits[$evenement->getIdEvenement()] ?? 0));
                    $complet = ($restantes <= 0);
                    ?>
                    <div class="col-md-6">
                        <div class="box ev h-100">
                            <div class="d-flex gap-3">
                                <div class="logo-sq">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <?php if ($complet): ?>
                                        <span class="tag" style="background:#fde8e8;color:#c0392b">Complet</span>
                                    <?php else: ?>
                                        <span class="tag"><?= $restantes ?> place<?= $restantes > 1 ? 's' : '' ?> restante<?= $restantes > 1 ? 's' : '' ?></span>
                                    <?php endif; ?>

                                    <h6 class="mt-1 mb-1"><?= htmlspecialchars($evenement->getTitre()) ?></h6>
                                    <div class="muted small-t">
                                        <i class="bi bi-geo-alt"></i>
                                        <?= htmlspecialchars($evenement->getLieu()) ?> · <?= (int)$evenement->getNbrPlaces() ?> places au total
                                    </div>
                                    <p class="muted small-t my-2"><?= htmlspecialchars($evenement->getDescription()) ?></p>

                                    <a class="btn btn-primary btn-sm mt-2 <?= $complet ? 'disabled' : '' ?>" href="#">S'inscrire</a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mt-2"
                                            data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                                        Aperçu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade preview-modal" id="preview<?= $id ?>" tabindex="-1"
                         data-lat="<?= $evenement->getLat() ?>" data-lng="<?= $evenement->getLng() ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="eyebrow">Aperçu de l'évènement</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="mb-3"><?= htmlspecialchars($evenement->getTitre()) ?></h5>

                                    <div class="mb-3">
                                        <div class="form-label">Lieu</div>
                                        <div><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evenement->getLieu()) ?></div>
                                    </div>

                                    <?php if ($evenement->getLat() !== null && $evenement->getLng() !== null): ?>
                                        <div class="mb-3">
                                            <div class="form-label">Localisation</div>
                                            <div class="map-preview" style="height:250px; width:100%; border-radius:8px;"></div>
                                            <a class="small" target="_blank" rel="noopener"
                                               href="https://www.openstreetmap.org/?mlat=<?= (float)$evenement->getLat() ?>&mlon=<?= (float)$evenement->getLng() ?>#map=17/<?= (float)$evenement->getLat() ?>/<?= (float)$evenement->getLng() ?>">
                                                Ouvrir dans OpenStreetMap
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <div class="form-label">Places</div>
                                        <div><?= $complet ? 'Complet' : $restantes . ' / ' . (int)$evenement->getNbrPlaces() . ' places restantes' ?></div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label">Description</div>
                                        <p class="mb-0"><?= nl2br(htmlspecialchars($evenement->getDescription())) ?></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <?php if (!$complet): ?>
                                        <a href="#" class="btn btn-primary">S'inscrire</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
        © 2026 Campus. Tous droits réservés.
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
<!-- en bas, après le script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
        var map = null;
        var marker = null;

        function placerMarqueur(lat, lng) {
        if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }
        function remplirLieu(lat, lng) {
        var champLieu = document.querySelector('input[name="lieu"]');
        champLieu.placeholder = "Recherche de l'adresse...";

        fetch('https://nominatim.openstreetmap.org/reverse?format=json&accept-language=fr&lat=' + lat + '&lon=' + lng)
        .then(function (r) { return r.json(); })
        .then(function (data) {
        if (data && data.display_name) {
        champLieu.value = data.display_name;
    }
    })
        .catch(function () {
        champLieu.placeholder = "";
    });
    }

        function rechercher() {
        var q = document.getElementById('recherche').value.trim();
        if (!q) return;

        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (data) {
        if (data.length === 0) {
        alert("Adresse introuvable.");
        return;
    }
        var lat = parseFloat(data[0].lat);
        var lng = parseFloat(data[0].lon);
        map.setView([lat, lng], 17);
        placerMarqueur(lat, lng);
        document.querySelector('input[name="lieu"]').value = data[0].display_name;
    });
    }

        // Remplacez maModale par l'id de votre modale
        document.getElementById('addModal').addEventListener('shown.bs.modal', function () {                        if (!map) {
        map = L.map('map').setView([48.8566, 2.3522], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

        map.on('click', function (e) {
        placerMarqueur(e.latlng.lat, e.latlng.lng);
        remplirLieu(e.latlng.lat, e.latlng.lng);
    });
    }
        setTimeout(function () { map.invalidateSize(); }, 100);
    });

        document.getElementById('btnRecherche').addEventListener('click', rechercher);

        document.getElementById('recherche').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
        e.preventDefault();
        rechercher();
    }
    });
</script>

<script>
    document.querySelectorAll('.preview-modal').forEach(function (modal) {
        var carte = null;

        modal.addEventListener('shown.bs.modal', function () {
            var lat = parseFloat(modal.dataset.lat);
            var lng = parseFloat(modal.dataset.lng);
            var div = modal.querySelector('.map-preview');

            if (!div || isNaN(lat) || isNaN(lng)) return;

            if (!carte) {
                carte = L.map(div).setView([lat, lng], 16);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(carte);
                L.marker([lat, lng]).addTo(carte);
            }
            setTimeout(function () { carte.invalidateSize(); }, 100);
        });
    });
</script>
</body>
</html>