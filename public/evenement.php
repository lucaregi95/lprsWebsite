<?php
session_start();
require_once "../bdd/bdd.php";
require_once "../src/model/Evenement.php";
require_once "../src/repository/EvenementRepository.php";
require_once "../src/model/Participe.php";
require_once "../src/repository/ParticipeRepository.php";

$eventRepository = new EvenementRepository();
$evenements = $eventRepository->getAllEvenements();
$inscrits = $eventRepository->getNbInscritsParEvenement();

$participeRepository = new ParticipeRepository();
$participes = $participeRepository->getAllParticipes();


$idUser=$_SESSION['id_utilisateur'];
$vueRole="SELECT role FROM v_utilisateurwithrole WHERE id_utilisateur=:idUser";



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
    <link href="style/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
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
                            <input type="text" class="form-event" name="lieu" readonly>
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

                        <div class="mb-3">
                            <label class="form-label">Date de l'Évènement</label>
                            <input type="date" class="form-event" name="date_evenement" required>
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
                                <?php if ($complet): ?>
                                <div class="logo-sq-complet">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <?php else: ?>
                                <div class="logo-sq">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <?php if ($complet): ?>
                                        <span class="tag" style="background:#fde8e8;color:#c0392b">Complet</span>
                                    <?php else: ?>
                                        <span class="tag"><?= $restantes ?> place<?= $restantes > 1 ? 's' : '' ?> restante<?= $restantes > 1 ? 's' : '' ?></span>
                                    <?php endif; ?>

                                    <h6 class="mt-1 mb-1"><?= ($evenement->getTitre()) ?></h6>
                                    <div class="muted small-t">
                                        <i class="bi bi-geo-alt"></i>
                                        <?= ($evenement->getLieu()) ?> <hr> <br>· <?= (int)$evenement->getNbrPlaces() ?> places au total
                                    </div>
                                    <p class="muted small-t my-2"><?= ($evenement->getDescription()) ?></p>
                                    <div class="mb-3">
                                        <p class="muted small-t my-2"><?= ($evenement->getDateEvenement()) ?></p>
                                    </div>
                                    <?php if ($complet): ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2"
                                                data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                                            Aperçu
                                        </button>
                                    <?php else: ?>
                                        <form method="POST" action="../src/traitement/newParticipe.php">
                                            <input type="hidden" name="ref_utilisateur" value="<?= $_SESSION['id_utilisateur'] ?>">
                                            <input type="hidden" name="ref_evenement" value="<?=$evenement->getIdEvenement()?>() ?>">
                                            <button class="btn btn-primary btn-sm mt-2 ">
                                                S'inscrire
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2"
                                                data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                                            Aperçu
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                                data-bs-toggle="modal" data-bs-target="#edit<?= $id ?>">
                                            Modifier
                                        </button>
                                    <?php endif; ?>
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
                                    <h5 class="mb-3"><?= ($evenement->getTitre()) ?></h5>

                                    <div class="mb-3">
                                        <div class="form-label">Lieu</div>
                                        <div><i class="bi bi-geo-alt"></i> <?= ($evenement->getLieu()) ?></div>
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
                                        <p class="mb-0"><?= $evenement->getDescription()?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="muted small-t my-2"><?= ($evenement->getDateEvenement()) ?></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <form method="POST" action="../src/traitement/suppEvenement.php">
                                        <input type="hidden" name="id_evenement" value="<?=$evenement->getIdEvenement() ?>">
                                        <input type="hidden" name="titre" value="<?=$evenement->getTitre() ?>">
                                        <input type="hidden" name="nbr_places" value="<?= $evenement->getNbrPlaces() ?>">
                                        <button class="btn btn-danger btn-sm mt-2 ">
                                        Supprimer
                                        </button>
                                    </form>
                                    <?php if (!$complet): ?>
                                        <form method="POST" action="../src/traitement/newParticipe.php">
                                            <input type="hidden" name="ref_utilisateur" value="<?= $_SESSION['id_utilisateur'] ?>">
                                            <input type="hidden" name="ref_evenement" value="<?=$evenement->getIdEvenement()?>() ?>">
                                            <button class="btn btn-primary btn-sm mt-2 ">
                                                S'inscrire
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $lat = $evenement->getLat();
                    $lng = $evenement->getLng();
                    $aPosition = ($lat !== null && $lat !== '' && $lng !== null && $lng !== '');
                    ?>
                    <div class="modal fade edit-modal" id="edit<?= $id ?>" tabindex="-1"
                         data-lat="<?= $aPosition ? $lat : '' ?>" data-lng="<?= $aPosition ? $lng : '' ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="eyebrow">Modifier l'évènement</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST" action="../src/traitement/modifierEvenement.php">
                                    <input type="hidden" name="id_evenement" value="<?=$evenement->getIdEvenement() ?>">

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nom de l'évènement</label>
                                            <input type="text" class="form-event" name="titre"
                                                   value="<?= $evenement->getTitre() ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-event" name="description" required><?=$evenement->getDescription() ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lieu</label>
                                            <input type="text" class="form-event" name="lieu"
                                                   value="<?= $evenement->getLieu() ?>" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Position actuelle</label>
                                            <div class="edit-map" style="height:300px; width:100%; border-radius:8px;"></div>
                                            <small class="text-muted">Cliquez sur la carte pour déplacer le point.</small>
                                        </div>

                                        <div class="row g-2 mb-3">
                                            <div class="col">
                                                <input type="number" step="any" min="-360" max="360" class="form-event edit-lat" name="lat"
                                                       value="<?= $aPosition ? $lat : '' ?>">


                                            </div>
                                            <div class="col">
                                                <input type="number" step="any" min="-360" max="360" class="form-event edit-lng" name="lng"
                                                       value="<?= $aPosition ? $lng : '' ?>">
                                            </div>
                                            <small class="text-muted">
                                                Pour trouver des coordonnées : clic droit sur un lieu dans Google Maps, puis cliquez sur les chiffres pour les copier.
                                            </small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nombre de Place</label>
                                            <input type="number" class="form-event" name="nbr_places" min="1"
                                                   value="<?= $evenement->getNbrPlaces() ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Date de l'Évènement</label>
                                            <input type="date" class="form-event" name="date_evenement" value="<?= $evenement->getDateEvenement() ?>" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
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

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>  <!-- idéalement dans le <head> -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.querySelectorAll('.edit-modal').forEach(function (modal) {
        var carte = null, marqueur = null;
        var champLat = modal.querySelector('.edit-lat');
        var champLng = modal.querySelector('.edit-lng');
        var champLieu = modal.querySelector('input[name="lieu"]');

        function placer(lat, lng) {
            if (marqueur) {
                marqueur.setLatLng([lat, lng]);
            } else {
                marqueur = L.marker([lat, lng]).addTo(carte);
            }
            champLat.value = lat;
            champLng.value = lng;
        }

        modal.addEventListener('shown.bs.modal', function () {
            var lat = parseFloat(modal.dataset.lat);
            var lng = parseFloat(modal.dataset.lng);
            var aPosition = !isNaN(lat) && !isNaN(lng);

            if (!carte) {
                carte = L.map(modal.querySelector('.edit-map'))
                    .setView(aPosition ? [lat, lng] : [48.8566, 2.3522], aPosition ? 16 : 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(carte);

                if (aPosition) placer(lat, lng);

                // Clic sur la carte : met à jour les champs et le lieu
                carte.on('click', function (e) {
                    placer(e.latlng.lat, e.latlng.lng);

                    fetch('https://nominatim.openstreetmap.org/reverse?format=json&accept-language=fr&lat='
                        + e.latlng.lat + '&lon=' + e.latlng.lng)
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            if (data && data.display_name) champLieu.value = data.display_name;
                        });
                });

                // Si on tape les coordonnées à la main, le marqueur suit
                function depuisChamps() {
                    var a = parseFloat(champLat.value), b = parseFloat(champLng.value);
                    if (!isNaN(a) && !isNaN(b)) {
                        placer(a, b);
                        carte.setView([a, b], 16);
                    }
                }
                champLat.addEventListener('change', depuisChamps);
                champLng.addEventListener('change', depuisChamps);
            }

            setTimeout(function () { carte.invalidateSize(); }, 100);
        });
    });
</script>
</body>
</html>