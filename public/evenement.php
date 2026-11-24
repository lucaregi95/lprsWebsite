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
    $nbEvenementsTotal = count($evenements);

// Infos par évènement (calculées une seule fois, utilisées par les filtres et par les cards)
    $infos = [];
    foreach ($evenements as $id => $e) {
        $nb       = nbInscrits($e->getIdEvenement());
        $partie   = $participeRepository->getParticipe($idUser, $e->getIdEvenement());
        $infos[$id] = [
                'nb'         => $nb,
                'restantes'  => $e->getNbrPlaces() - $nb,
                'yp'         => ($partie == null) ? null : $partie->getEstOrga(),
                'eventUser'  => $eventRepository->getEvenementOrganiseParUtilisateur($idUser, $e->getIdEvenement()),
                'ts'         => timestampEvenement($e->getDateEvenement()),
        ];
    }

// ---- Tri et filtres (envoyés en GET par le formulaire de l'aside) ----
    $q            = mb_strtolower(trim((string) ($_GET['q'] ?? '')));
    $tri          = (string) ($_GET['tri'] ?? 'defaut');
    $lieuFiltre   = mb_strtolower(trim((string) ($_GET['lieu'] ?? '')));
    $du           = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) ($_GET['du'] ?? '')) ? $_GET['du'] : '';
    $au           = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) ($_GET['au'] ?? '')) ? $_GET['au'] : '';
    $filtreDispo  = isset($_GET['dispo']);
    $filtreInscrit = isset($_GET['inscrit']);
    $filtreOrga   = isset($_GET['orga']);

    $evenements = array_filter($evenements, function ($e, $id) use ($infos, $q, $lieuFiltre, $du, $au, $filtreDispo, $filtreInscrit, $filtreOrga, $vueRole) {
        $i = $infos[$id];
        if ($q !== '' && mb_strpos(mb_strtolower($e->getTitre() . ' ' . $e->getLieu() . ' ' . $e->getDescription()), $q) === false) return false;
        if ($lieuFiltre !== '' && mb_strpos(mb_strtolower((string) $e->getLieu()), $lieuFiltre) === false) return false;
        if ($du !== '' && $i['ts'] < strtotime($du)) return false;
        if ($au !== '' && $i['ts'] > strtotime($au)) return false;
        if ($filtreDispo && $i['restantes'] <= 0) return false;
        if ($filtreInscrit && $i['yp'] != 2) return false;
        if ($filtreOrga && !($vueRole === "partenaire" && $i['eventUser'] !== null)) return false;
        return true;
    }, ARRAY_FILTER_USE_BOTH);

    $comparateurs = [
            'date-asc'      => function ($a, $b, $ia, $ib) { return $ia['ts'] <=> $ib['ts']; },
            'date-desc'     => function ($a, $b, $ia, $ib) { return $ib['ts'] <=> $ia['ts']; },
            'places-desc'   => function ($a, $b, $ia, $ib) { return $ib['restantes'] <=> $ia['restantes']; },
            'places-asc'    => function ($a, $b, $ia, $ib) { return $ia['restantes'] <=> $ib['restantes']; },
            'inscrits-desc' => function ($a, $b, $ia, $ib) { return $ib['nb'] <=> $ia['nb']; },
            'titre'         => function ($a, $b, $ia, $ib) { return strcasecmp($a->getTitre(), $b->getTitre()); },
    ];
    if (isset($comparateurs[$tri])) {
        $cmp = $comparateurs[$tri];
        $cles = array_keys($evenements);
        usort($cles, function ($ka, $kb) use ($cmp, $evenements, $infos) {
            return $cmp($evenements[$ka], $evenements[$kb], $infos[$ka], $infos[$kb]) ?: ($ka <=> $kb);
        });
        $tries = [];
        foreach ($cles as $k) {
            $tries[$k] = $evenements[$k];
        }
        $evenements = $tries;
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

                <form method="GET" action="evenement.php" id="filtres" class="box mb-3 filter-box">
                    <h6 class="mb-3">Trier et filtrer</h6>

                    <label class="form-label" for="tri">Trier par</label>
                    <select id="tri" name="tri" class="form-select form-select-sm mb-3">
                        <?php foreach (['defaut' => 'Ordre par défaut', 'date-asc' => 'Date : la plus proche en premier', 'date-desc' => 'Date : la plus lointaine en premier', 'places-desc' => 'Places restantes : le plus', 'places-asc' => 'Places restantes : le moins', 'inscrits-desc' => "Plus d'inscrits", 'titre' => 'Nom (A → Z)'] as $val => $lib): ?>
                            <option value="<?= $val ?>" <?= $tri === $val ? 'selected' : '' ?>><?= h($lib) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label class="form-label" for="f-lieu">Lieu</label>
                    <input type="text" id="f-lieu" name="lieu" class="form-control form-control-sm mb-3" placeholder="Ville, adresse…" value="<?= h($_GET['lieu'] ?? '') ?>">

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="f-du">Du</label>
                            <input type="date" id="f-du" name="du" class="form-control form-control-sm" value="<?= h($du) ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="f-au">Au</label>
                            <input type="date" id="f-au" name="au" class="form-control form-control-sm" value="<?= h($au) ?>">
                        </div>
                    </div>

                    <div class="form-check small-t mb-1">
                        <input class="form-check-input" type="checkbox" name="dispo" id="f-dispo" <?= $filtreDispo ? 'checked' : '' ?>>
                        <label class="form-check-label" for="f-dispo">Places disponibles uniquement</label>
                    </div>
                    <div class="form-check small-t mb-1">
                        <input class="form-check-input" type="checkbox" name="inscrit" id="f-inscrit" <?= $filtreInscrit ? 'checked' : '' ?>>
                        <label class="form-check-label" for="f-inscrit">Évènements où je suis inscrit</label>
                    </div>
                    <?php if ($vueRole === "partenaire"): ?>
                        <div class="form-check small-t mb-1">
                            <input class="form-check-input" type="checkbox" name="orga" id="f-orga" <?= $filtreOrga ? 'checked' : '' ?>>
                            <label class="form-check-label" for="f-orga">Évènements que j'organise</label>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-3">Appliquer</button>
                    <a href="evenement.php" class="btn btn-outline-secondary btn-sm w-100 mt-2">Réinitialiser</a>
                </form>
            </aside>

            <div class="col-lg-9">
                <div class="input-group input-group-sm mb-3">
                    <input class="form-control" form="filtres" type="search" name="q" value="<?= h($_GET['q'] ?? '') ?>" placeholder="Rechercher un évènement (nom, lieu, description)"/>
                    <button class="btn btn-outline-primary" form="filtres" type="submit">Rechercher</button>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h5 class="mb-0">Évènements à venir</h5>
                    <span class="small-t"><?= count($evenements) ?> évènement<?= count($evenements) > 1 ? 's' : '' ?></span>
                </div>

                <div class="row g-3" id="liste-events">
                    <?php if (empty($evenements)): ?>
                        <p class="muted"><?= $nbEvenementsTotal === 0 ? 'Aucun évènement pour le moment.' : 'Aucun évènement ne correspond à ces critères.' ?></p>
                    <?php endif; ?>
                    <?php foreach ($evenements as $id => $evenement): ?>
                        <?php
                        $nbInscrits      = $infos[$id]['nb'];
                        $placesRestantes = $infos[$id]['restantes'];
                        $complet         = ($placesRestantes <= 0);
                        $eventUser       = $infos[$id]['eventUser'];
                        $Yparticipe      = $infos[$id]['yp'];

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
                        <div class="col-md-6">
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
                                    <span><?= h($evenement->getLieu()) ?></span>
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
                                        <button type="button" class="btn btn-success btn-sm"
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
                                                <button class="btn btn-outline-danger">Supprimer</button>
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
<?php } ?>