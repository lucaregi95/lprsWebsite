<?php
session_start();

if(!(isset($_SESSION['id_utilisateur']))){
    header('Location: connexion.php');
}else{

    require_once "../bdd/bdd.php";
    require_once "../src/model/Evenement.php";
    require_once "../src/repository/EvenementRepository.php";
    require_once "../src/model/Participe.php";
    require_once "../src/repository/ParticipeRepository.php";

    $idUser=$_SESSION['id_utilisateur'];

    $eventRepository = new EvenementRepository();
    $evenements = $eventRepository->getAllEvenements();
    $inscrits = $eventRepository->getNbInscritsParEvenement();



    $participeRepository = new ParticipeRepository();
    $participes = $participeRepository->getAllParticipes();



    $connexionBdd = (new Bdd())->getConnexionBdd();


    $sql="SELECT role FROM v_utilisateurwithrole WHERE id_utilisateur=:id";
    $req = $connexionBdd->prepare($sql);
    $req->execute([':id'=>$idUser]);
    $result = $req->fetch(pdo::FETCH_ASSOC);
    $vueRole=$result['role'];

    function nbInscrits($idevent) {
        $connexionBdd = (new Bdd())->getConnexionBdd();
        $sql = "SELECT COUNT(*) FROM participe WHERE ref_evenement = :idevent";
        $req = $connexionBdd->prepare($sql);
        $req->execute([':idevent' => $idevent]);
        return (int) $req->fetchColumn();
    }

    function timestampEvenement($date) {
        $date = trim((string) $date);
        if (preg_match('#^(\d{2})/(\d{2})/(\d{4})#', $date, $m)) {
            return mktime(0, 0, 0, (int) $m[2], (int) $m[1], (int) $m[3]);
        }
        $t = strtotime($date);
        return $t ? $t : 0;
    }

    function h($valeur) {
        return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
    }

    $demain = date('Y-m-d', strtotime('tomorrow'));


    $sql = "SELECT SUM(nbr_places) FROM evenement WHERE 1";
    $req = $connexionBdd->prepare($sql);
    $req->execute();
    $result=$req->fetchColumn();
    $totNb_places=$result;

// Évènements passés : on ne les affiche pas (l'évènement du jour reste visible)
    $aujourdhui = strtotime('today');
    $evenements = array_filter($evenements, function ($e) use ($aujourdhui) {
        return timestampEvenement($e->getDateEvenement()) >= $aujourdhui;
    });
    $totNb_places = 0;
    foreach ($evenements as $e) {
        $totNb_places += (int) $e->getNbrPlaces();
    }



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
            <?php if($vueRole === "partenaire"): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Proposer un évènement
                </button>
            <?php endif; ?>
        </div>
    </header>
    <main class="container mt-4">
        <!-- Modal : proposer un évènement -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalTitre" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <div class="eyebrow">Nouvel évènement</div>
                            <h5 class="modal-title" id="addModalTitre">Proposer un évènement</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form method="POST" action="../src/traitement/newEvenement.php">
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label" for="add-titre">Nom de l'évènement</label>
                                <input type="text" class="form-event" id="add-titre" name="titre" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-event" id="description" name="description" required></textarea>
                            </div>

                            <input type="hidden" name="lieu">

                            <!-- Recherche + carte -->
                            <div class="mb-3">
                                <label class="form-label" for="recherche">Position exacte</label>
                                <div class="input-group mb-2">
                                    <input type="text" id="recherche" class="form-control" placeholder="Tapez une adresse (ex : 10 rue de Rivoli, Paris)">
                                    <button type="button" id="btnRecherche" class="btn btn-outline-primary">Rechercher</button>
                                </div>
                                <div id="map" class="map-box"></div>
                                <small class="form-hint">Vous pouvez aussi cliquer sur la carte pour ajuster le point.</small>
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                            </div>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="add-places">Nombre de places</label>
                                    <input type="number" min="1" max="350" step="1" class="form-event" id="add-places" name="nbr_places" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="add-date">Date de l'évènement</label>
                                    <input type="date" min="<?= $demain ?>" class="form-event" id="add-date" name="date_evenement" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter l'évènement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="box mb-3">
                    <h6>Statistique sur les évènements</h6>
                    <span class="tag tag-warn">Nombre de places totales : <?= (int) $totNb_places ?></span>
                </div>

                <div class="box mb-3 filter-box">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Trier et filtrer</h6>
                        <button type="button" id="reset-filtres" class="link-btn">Réinitialiser</button>
                    </div>

                    <label class="form-label" for="tri">Trier par</label>
                    <select id="tri" class="form-select form-select-sm mb-3">
                        <option value="defaut">Ordre par défaut</option>
                        <option value="date-asc">Date : la plus proche en premier</option>
                        <option value="date-desc">Date : la plus lointaine en premier</option>
                        <option value="places-desc">Places restantes : le plus</option>
                        <option value="places-asc">Places restantes : le moins</option>
                        <option value="inscrits-desc">Plus d'inscrits</option>
                        <option value="titre">Nom (A → Z)</option>
                        <option value="distance">Proximité : le plus près</option>
                    </select>

                    <label class="form-label" for="f-lieu">Lieu</label>
                    <input type="text" id="f-lieu" class="form-control form-control-sm mb-3" placeholder="Ville, adresse…">

                    <label class="form-label" for="f-rayon">Autour de moi</label>
                    <select id="f-rayon" class="form-select form-select-sm">
                        <option value="">Peu importe</option>
                        <option value="5">Moins de 5 km</option>
                        <option value="10">Moins de 10 km</option>
                        <option value="25">Moins de 25 km</option>
                        <option value="50">Moins de 50 km</option>
                        <option value="100">Moins de 100 km</option>
                    </select>
                    <small id="geo-statut" class="form-hint mb-3"></small>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="f-du">Du</label>
                            <input type="date" id="f-du" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="f-au">Au</label>
                            <input type="date" id="f-au" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-check small-t mb-1">
                        <input class="form-check-input" type="checkbox" id="f-dispo">
                        <label class="form-check-label" for="f-dispo">Places disponibles uniquement</label>
                    </div>
                    <div class="form-check small-t mb-1">
                        <input class="form-check-input" type="checkbox" id="f-inscrit">
                        <label class="form-check-label" for="f-inscrit">Évènements où je suis inscrit</label>
                    </div>
                    <?php if ($vueRole === "partenaire"): ?>
                        <div class="form-check small-t">
                            <input class="form-check-input" type="checkbox" id="f-orga">
                            <label class="form-check-label" for="f-orga">Évènements que j'organise</label>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="mb-3">
                    <input class="form-control form-control-sm" id="f-recherche" placeholder="Rechercher un évènement (nom, lieu, description)"/>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h5 class="mb-0">Évènements à venir</h5>
                    <span class="small-t" id="compteur"></span>
                </div>


                <div class="row g-3" id="liste-events">
                    <?php if (empty($evenements)): ?>
                        <p class="muted">Aucun évènement pour le moment.</p>
                    <?php endif; ?>
                    <?php foreach ($evenements as $id => $evenement): ?>
                        <?php
                        $nbInscrits = nbInscrits($evenement->getIdEvenement());
                        $placesRestantes = $evenement->getNbrPlaces() - $nbInscrits;

                        $complet = ($placesRestantes <= 0);
                        $eventUser= $eventRepository->getEvenementOrganiseParUtilisateur($idUser,$evenement->getIdEvenement());
                        $partie= $participeRepository->getParticipe($idUser,$evenement->getIdEvenement());
                        if ($partie ==null){
                            $Yparticipe=null;

                        }else{
                            $Yparticipe=$partie->getEstOrga();
                        }

                        $estOrga       = ($vueRole === "partenaire" && $eventUser !== null);
                        $inscrit       = ($Yparticipe == 2);
                        $peutSinscrire = (!$complet && !$inscrit && $Yparticipe == null && $vueRole === "etudiant");
                        $peutModifier  = (!$complet && !$inscrit && $estOrga);
                        $peutApercu    = ($complet || $inscrit || $peutSinscrire || $peutModifier);

                        $pourcentage = $evenement->getNbrPlaces() > 0
                                ? min(100, round($nbInscrits / $evenement->getNbrPlaces() * 100))
                                : 0;

                        $moisCourts = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
                        $ts         = timestampEvenement($evenement->getDateEvenement());
                        $jour       = $ts ? date('j', $ts) : '–';
                        $mois       = $ts ? $moisCourts[(int) date('n', $ts) - 1] : '';
                        $dateLongue = $ts ? date('d/m/Y', $ts) : h($evenement->getDateEvenement());

                        $lat = $evenement->getLat();
                        $lng = $evenement->getLng();
                        $aPosition = ($lat !== null && $lat !== '' && $lng !== null && $lng !== '');
                        ?>

                        <!-- Card évènement -->
                        <div class="col-md-6 event-item"
                             data-index="<?= (int) $id ?>"
                             data-date="<?= $ts ? date('Y-m-d', $ts) : '' ?>"
                             data-ts="<?= (int) $ts ?>"
                             data-places="<?= (int) $placesRestantes ?>"
                             data-inscrits="<?= (int) $nbInscrits ?>"
                             data-titre="<?= h(mb_strtolower($evenement->getTitre())) ?>"
                             data-texte="<?= h(mb_strtolower($evenement->getTitre() . ' ' . $evenement->getLieu() . ' ' . $evenement->getDescription())) ?>"
                             data-lieu="<?= h(mb_strtolower($evenement->getLieu())) ?>"
                             data-lat="<?= $aPosition ? h($lat) : '' ?>"
                             data-lng="<?= $aPosition ? h($lng) : '' ?>"
                             data-inscrit="<?= $inscrit ? 1 : 0 ?>"
                             data-orga="<?= $estOrga ? 1 : 0 ?>">
                            <article class="event-card <?= $complet ? 'is-full' : '' ?>">
                                <div class="event-head">
                                    <div class="date">
                                        <span class="d-block fs-5"><?= $jour ?></span>
                                        <small><?= $mois ?></small>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="event-tags">
                                            <?php if ($complet): ?>
                                                <span class="tag tag-full">Complet</span>
                                            <?php else: ?>
                                                <span class="tag"><?= $placesRestantes ?> place<?= $placesRestantes > 1 ? 's' : '' ?> restante<?= $placesRestantes > 1 ? 's' : '' ?></span>
                                            <?php endif; ?>
                                            <?php if ($inscrit): ?>
                                                <span class="tag tag-ok"><i class="bi bi-check2"></i> Inscrit</span>
                                            <?php endif; ?>
                                        </div>
                                        <h6 class="event-title"><?= h($evenement->getTitre()) ?></h6>
                                    </div>
                                </div>

                                <div class="event-lieu">
                                    <i class="bi bi-geo-alt"></i>
                                    <span><?= h($evenement->getLieu()) ?> <em class="event-dist" hidden></em></span>
                                </div>

                                <p class="event-desc"><?= h($evenement->getDescription()) ?></p>

                                <div class="event-fill">
                                    <div class="event-fill-label">
                                    <span><i class="bi bi-people"></i>
                                        <?= $nbInscrits == 0 ? 'Aucun inscrit' : $nbInscrits . ' inscrit' . ($nbInscrits > 1 ? 's' : '') ?>
                                    </span>
                                        <span><?= (int) $evenement->getNbrPlaces() ?> places</span>
                                    </div>
                                    <div class="event-progress" role="progressbar" aria-valuenow="<?= $pourcentage ?>" aria-valuemin="0" aria-valuemax="100">
                                        <span style="width:<?= $pourcentage ?>%"></span>
                                    </div>
                                </div>

                                <div class="event-foot">
                                    <?php if ($peutApercu): ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                                            Aperçu
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($peutModifier): ?>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#edit<?= $id ?>">
                                            Modifier
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($peutSinscrire): ?>
                                        <form method="POST" action="../src/traitement/newParticipe.php">
                                            <input type="hidden" name="ref_utilisateur" value="<?= (int) $_SESSION['id_utilisateur'] ?>">
                                            <input type="hidden" name="ref_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">
                                            <button class="btn btn-primary btn-sm">S'inscrire</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($inscrit): ?>
                                        <form method="POST" action="../src/traitement/suppParticipe.php">
                                            <input type="hidden" name="id_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">
                                            <input type="hidden" name="id_user" value="<?= (int) $idUser ?>">
                                            <button class="btn btn-outline-danger btn-sm">Se désinscrire</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>

                        <!-- Modal : aperçu -->
                        <div class="modal fade preview-modal" id="preview<?= $id ?>" tabindex="-1" aria-hidden="true"
                             data-lat="<?= h($lat) ?>" data-lng="<?= h($lng) ?>">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="min-w-0">
                                            <div class="eyebrow">Aperçu de l'évènement</div>
                                            <h5 class="modal-title"><?= h($evenement->getTitre()) ?></h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="event-tags mb-3">
                                            <?php if ($complet): ?>
                                                <span class="tag tag-full">Complet</span>
                                            <?php else: ?>
                                                <span class="tag"><?= $placesRestantes ?> place<?= $placesRestantes > 1 ? 's' : '' ?> restante<?= $placesRestantes > 1 ? 's' : '' ?></span>
                                            <?php endif; ?>
                                            <?php if ($inscrit): ?>
                                                <span class="tag tag-ok"><i class="bi bi-check2"></i> Inscrit</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="info-grid">
                                            <div class="info-item">
                                                <i class="bi bi-calendar-event"></i>
                                                <div>
                                                    <span class="info-label">Date</span>
                                                    <?= $dateLongue ?>
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <i class="bi bi-people"></i>
                                                <div>
                                                    <span class="info-label">Participants</span>
                                                    <?= $nbInscrits ?> / <?= (int) $evenement->getNbrPlaces() ?> places
                                                </div>
                                            </div>
                                            <div class="info-item info-wide">
                                                <i class="bi bi-geo-alt"></i>
                                                <div>
                                                    <span class="info-label">Lieu</span>
                                                    <?= h($evenement->getLieu()) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <span class="info-label">Description</span>
                                            <p class="mb-0 event-full-desc"><?= nl2br(h($evenement->getDescription())) ?></p>
                                        </div>

                                        <?php if ($evenement->getLat() !== null && $evenement->getLng() !== null): ?>
                                            <div>
                                                <span class="info-label">Localisation</span>
                                                <div class="map-preview map-box"></div>
                                                <a class="link-more d-inline-block mt-2" target="_blank" rel="noopener"
                                                   href="https://www.openstreetmap.org/?mlat=<?= (float) $evenement->getLat() ?>&mlon=<?= (float) $evenement->getLng() ?>#map=17/<?= (float) $evenement->getLat() ?>/<?= (float) $evenement->getLng() ?>">
                                                    Ouvrir dans OpenStreetMap
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>

                                        <?php if ($estOrga): ?>
                                            <form method="POST" action="../src/traitement/suppEvenement.php">
                                                <input type="hidden" name="id_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">
                                                <input type="hidden" name="titre" value="<?= h($evenement->getTitre()) ?>">
                                                <input type="hidden" name="nbr_places" value="<?= (int) $evenement->getNbrPlaces() ?>">
                                                <button class="btn btn-danger">Supprimer</button>
                                            </form>
                                        <?php elseif (!$complet && $Yparticipe == null): ?>
                                            <form method="POST" action="../src/traitement/newParticipe.php">
                                                <input type="hidden" name="ref_utilisateur" value="<?= (int) $_SESSION['id_utilisateur'] ?>">
                                                <input type="hidden" name="ref_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">
                                                <button class="btn btn-primary">S'inscrire</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($inscrit): ?>
                                            <form method="POST" action="../src/traitement/suppParticipe.php">
                                                <input type="hidden" name="id_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">
                                                <input type="hidden" name="id_user" value="<?= (int) $idUser ?>">
                                                <button class="btn btn-outline-danger">Se désinscrire</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal : modification -->
                        <div class="modal fade edit-modal" id="edit<?= $id ?>" tabindex="-1" aria-hidden="true"
                             data-lat="<?= $aPosition ? h($lat) : '' ?>" data-lng="<?= $aPosition ? h($lng) : '' ?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="min-w-0">
                                            <div class="eyebrow">Modifier l'évènement</div>
                                            <h5 class="modal-title"><?= h($evenement->getTitre()) ?></h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>

                                    <form method="POST" action="../src/traitement/modifierEvenement.php">
                                        <input type="hidden" name="id_evenement" value="<?= (int) $evenement->getIdEvenement() ?>">

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nom de l'évènement</label>
                                                <input type="text" class="form-event" name="titre"
                                                       value="<?= h($evenement->getTitre()) ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-event" name="description" required><?= h($evenement->getDescription()) ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Lieu</label>
                                                <input type="text" class="form-event" name="lieu"
                                                       value="<?= h($evenement->getLieu()) ?>" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Position actuelle</label>
                                                <div class="edit-map map-box"></div>
                                                <small class="form-hint">Cliquez sur la carte pour déplacer le point.</small>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Latitude</label>
                                                    <input type="number" step="any" min="-360" max="360" class="form-event edit-lat" name="lat"
                                                           value="<?= $aPosition ? h($lat) : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Longitude</label>
                                                    <input type="number" step="any" min="-360" max="360" class="form-event edit-lng" name="lng"
                                                           value="<?= $aPosition ? h($lng) : '' ?>">
                                                </div>
                                                <div class="col-12">
                                                    <small class="form-hint">
                                                        Pour trouver des coordonnées : clic droit sur un lieu dans Google Maps, puis cliquez sur les chiffres pour les copier.
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Nombre de places</label>
                                                    <input type="number" class="form-event" name="nbr_places" min="<?= $nbInscrits ?>" max="350" step="1" value="<?= (int) $evenement->getNbrPlaces() ?>" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Date de l'évènement</label>
                                                    <input type="date" min="<?= $demain ?>" class="form-event" name="date_evenement" value="<?= h($evenement->getDateEvenement()) ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p class="muted col-12" id="aucun-resultat" hidden>Aucun évènement ne correspond à ces critères.</p>
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
    <script>
        (function () {
            var liste = document.getElementById('liste-events');
            if (!liste) return;
            var cards = Array.prototype.slice.call(liste.querySelectorAll('.event-item'));
            var $ = function (id) { return document.getElementById(id); };
            var position = null; // {lat, lng} de l'utilisateur

            function distanceKm(lat1, lng1, lat2, lng2) {
                var r = 6371, rad = Math.PI / 180;
                var dLat = (lat2 - lat1) * rad, dLng = (lng2 - lng1) * rad;
                var x = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * rad) * Math.cos(lat2 * rad) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
                return 2 * r * Math.asin(Math.sqrt(x));
            }

            function calculerDistances() {
                cards.forEach(function (c) {
                    var lat = parseFloat(c.dataset.lat), lng = parseFloat(c.dataset.lng);
                    var badge = c.querySelector('.event-dist');
                    if (position && !isNaN(lat) && !isNaN(lng)) {
                        c._km = distanceKm(position.lat, position.lng, lat, lng);
                        badge.textContent = '· à ' + (c._km < 10 ? c._km.toFixed(1) : Math.round(c._km)).toString().replace('.', ',') + ' km';
                        badge.hidden = false;
                    } else {
                        c._km = null;
                        badge.hidden = true;
                    }
                });
            }

            function appliquer() {
                var q = $('f-recherche').value.trim().toLowerCase();
                var lieu = $('f-lieu').value.trim().toLowerCase();
                var rayon = parseFloat($('f-rayon').value);
                var du = $('f-du').value, au = $('f-au').value;
                var dispo = $('f-dispo').checked, inscrit = $('f-inscrit').checked;
                var orga = $('f-orga') ? $('f-orga').checked : false;

                var visibles = cards.filter(function (c) {
                    var ok = true;
                    if (q && c.dataset.texte.indexOf(q) === -1) ok = false;
                    if (lieu && c.dataset.lieu.indexOf(lieu) === -1) ok = false;
                    if (du && (!c.dataset.date || c.dataset.date < du)) ok = false;
                    if (au && (!c.dataset.date || c.dataset.date > au)) ok = false;
                    if (dispo && parseInt(c.dataset.places, 10) <= 0) ok = false;
                    if (inscrit && c.dataset.inscrit !== '1') ok = false;
                    if (orga && c.dataset.orga !== '1') ok = false;
                    if (!isNaN(rayon) && position && (c._km == null || c._km > rayon)) ok = false;
                    c.hidden = !ok;
                    return ok;
                });

                var tri = $('tri').value;
                var cmp = {
                    'defaut':        function (a, b) { return a.dataset.index - b.dataset.index; },
                    'date-asc':      function (a, b) { return a.dataset.ts - b.dataset.ts; },
                    'date-desc':     function (a, b) { return b.dataset.ts - a.dataset.ts; },
                    'places-desc':   function (a, b) { return b.dataset.places - a.dataset.places; },
                    'places-asc':    function (a, b) { return a.dataset.places - b.dataset.places; },
                    'inscrits-desc': function (a, b) { return b.dataset.inscrits - a.dataset.inscrits; },
                    'titre':         function (a, b) { return a.dataset.titre.localeCompare(b.dataset.titre, 'fr'); },
                    'distance':      function (a, b) {
                        if (a._km == null && b._km == null) return 0;
                        if (a._km == null) return 1;
                        if (b._km == null) return -1;
                        return a._km - b._km;
                    }
                }[tri];

                cards.slice().sort(cmp).forEach(function (c) { liste.appendChild(c); });

                $('compteur').textContent = visibles.length + ' évènement' + (visibles.length > 1 ? 's' : '');
                $('aucun-resultat').hidden = visibles.length > 0 || cards.length === 0;
                liste.appendChild($('aucun-resultat'));
            }

            // Demande la position une seule fois, quand elle devient utile
            function avecPosition(suite) {
                if (position) { suite(); return; }
                var statut = $('geo-statut');
                if (!navigator.geolocation) {
                    statut.textContent = "La géolocalisation n'est pas disponible sur ce navigateur.";
                    $('f-rayon').value = '';
                    if ($('tri').value === 'distance') $('tri').value = 'defaut';
                    suite();
                    return;
                }
                statut.textContent = 'Recherche de votre position…';
                navigator.geolocation.getCurrentPosition(function (p) {
                    position = { lat: p.coords.latitude, lng: p.coords.longitude };
                    statut.textContent = 'Position détectée.';
                    calculerDistances();
                    suite();
                }, function () {
                    statut.textContent = "Position refusée ou indisponible. Autorisez-la dans votre navigateur pour utiliser ce filtre.";
                    $('f-rayon').value = '';
                    if ($('tri').value === 'distance') $('tri').value = 'defaut';
                    suite();
                }, { timeout: 10000 });
            }

            ['f-recherche', 'f-lieu', 'f-du', 'f-au'].forEach(function (id) {
                $(id).addEventListener('input', appliquer);
            });
            ['f-dispo', 'f-inscrit', 'f-orga'].forEach(function (id) {
                if ($(id)) $(id).addEventListener('change', appliquer);
            });
            $('tri').addEventListener('change', function () {
                if (this.value === 'distance') avecPosition(appliquer); else appliquer();
            });
            $('f-rayon').addEventListener('change', function () {
                if (this.value) avecPosition(appliquer); else appliquer();
            });
            $('reset-filtres').addEventListener('click', function () {
                ['f-recherche', 'f-lieu', 'f-du', 'f-au'].forEach(function (id) { $(id).value = ''; });
                ['f-dispo', 'f-inscrit', 'f-orga'].forEach(function (id) { if ($(id)) $(id).checked = false; });
                $('tri').value = 'defaut';
                $('f-rayon').value = '';
                appliquer();
            });

            appliquer();
        })();
    </script>
    </body>
    </html>
<?php } ?>