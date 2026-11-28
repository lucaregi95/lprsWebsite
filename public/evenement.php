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

    // Liste de tous les utilisateurs dont le rôle est "professeur"
    $sql = "SELECT id_utilisateur, nom, prenom FROM v_utilisateurwithrole WHERE role = :role";
    $req = $connexionBdd->prepare($sql);
    $req->execute([':role' => 'professeur']);
    $profUtilisateurs = $req->fetchAll(PDO::FETCH_ASSOC);   // tableau de lignes : un professeur par ligne


    function nbInscrits($idevent) {
        $connexionBdd = (new Bdd())->getConnexionBdd();
        $sql = "SELECT COUNT(*) FROM participe WHERE ref_evenement = :idevent";
        $req = $connexionBdd->prepare($sql);
        $req->execute([':idevent' => $idevent]);
        return $req->fetchColumn();
    }

    $demain = date('Y-m-d', strtotime('tomorrow'));


    $sql = "SELECT SUM(nbr_places) FROM evenement WHERE 1";
    $req = $connexionBdd->prepare($sql);
    $req->execute();
    $result=$req->fetchColumn();
    $totNb_places=$result;




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
            <?php if ($vueRole !== "gestionnaire"): ?>
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

                            <?php if ($vueRole === "etudiant"): ?>
                                <div class="mb-3">
                                    <label class="form-label" for="add-prof">Professeur organisateur</label>
                                    <select class="form-event" id="add-prof" name="ref_professeur" required>
                                        <option value="" disabled selected>Choisir un professeur</option>
                                        <?php foreach ($profUtilisateurs as $profUtilisateur): ?>
                                            <option value="<?= $profUtilisateur['id_utilisateur'] ?>"><?= $profUtilisateur['prenom'] . ' ' . $profUtilisateur['nom'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-hint">Un professeur doit faire partie des organisateurs pour que l'évènement soit publié.</small>
                                </div>
                            <?php endif; ?>
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
                    <h6>
                        Statistique sur les évènements
                    </h6>
                    <br><span class="tag" style="background:#fdf8e8;color:#ae982c">Nombre de place totale : <?= $totNb_places?></span>


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
                        // Évènement déjà passé : on saute au suivant, il n'est pas affiché
                        if (strtotime($evenement->getDateEvenement()) < strtotime('today')) {
                            continue;
                        }

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

                        $estOrga       = $eventUser !== null;
                        $inscrit       = $Yparticipe == 2;

                        $peutSinscrire = (!$complet && !$inscrit && $Yparticipe == null && $vueRole !== "gestionnaire");
                        $peutModifier  = (!$complet && !$inscrit && $estOrga);
                        $peutApercu    = ($complet || $inscrit || $peutSinscrire || $peutModifier);

                        $pourcentage = $evenement->getNbrPlaces() > 0
                                ? min(100, round($nbInscrits / $evenement->getNbrPlaces() * 100))
                                : 0;

                        $moisCourts = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
                        $ts         = strtotime($evenement->getDateEvenement());
                        $jour       = $ts ? date('j', $ts) : '–';
                        $mois       = $ts ? $moisCourts[date('n', $ts) - 1] : '';
                        $dateLongue = $ts ? date('d/m/Y', $ts) : $evenement->getDateEvenement();

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
                                        <h6 class="event-title"><?= $evenement->getTitre() ?></h6>
                                    </div>
                                </div>

                                <div class="event-lieu">
                                    <i class="bi bi-geo-alt"></i>
                                    <span><?= $evenement->getLieu() ?></span>
                                </div>

                                <p class="event-desc"><?= $evenement->getDescription() ?></p>

                                <div class="event-fill">
                                    <div class="event-fill-label">
                                    <span><i class="bi bi-people"></i>
                                        <?= $nbInscrits == 0 ? 'Aucun inscrit' : $nbInscrits . ' inscrit' . ($nbInscrits > 1 ? 's' : '') ?>
                                    </span>
                                        <span><?= $evenement->getNbrPlaces() ?> places</span>
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
                                            <input type="hidden" name="ref_utilisateur" value="<?= $_SESSION['id_utilisateur'] ?>">
                                            <input type="hidden" name="ref_evenement" value="<?= $evenement->getIdEvenement() ?>">
                                            <button class="btn btn-primary btn-sm">S'inscrire</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($inscrit): ?>
                                        <form method="POST" action="../src/traitement/suppParticipe.php">
                                            <input type="hidden" name="id_evenement" value="<?= $evenement->getIdEvenement() ?>">
                                            <input type="hidden" name="id_user" value="<?= $idUser ?>">
                                            <button class="btn btn-outline-danger btn-sm">Se désinscrire</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>

                        <!-- Modal : aperçu -->
                        <div class="modal fade preview-modal" id="preview<?= $id ?>" tabindex="-1" aria-hidden="true"
                             data-lat="<?= $lat ?>" data-lng="<?= $lng ?>">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="min-w-0">
                                            <div class="eyebrow">Aperçu de l'évènement</div>
                                            <h5 class="modal-title"><?= $evenement->getTitre() ?></h5>
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
                                                    <?= $nbInscrits ?> / <?=  $evenement->getNbrPlaces() ?> places
                                                </div>
                                            </div>
                                            <div class="info-item info-wide">
                                                <i class="bi bi-geo-alt"></i>
                                                <div>
                                                    <span class="info-label">Lieu</span>
                                                    <?= $evenement->getLieu()?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <span class="info-label">Description</span>
                                            <p class="mb-0 event-full-desc"><?= ($evenement->getDescription()) ?></p>
                                        </div>

                                        <?php if ($evenement->getLat() !== null && $evenement->getLng() !== null): ?>
                                            <div>
                                                <span class="info-label">Localisation</span>
                                                <div class="map-preview map-box"></div>
                                                <a class="link-more d-inline-block mt-2" target="_blank" rel="noopener"
                                                   href="https://www.openstreetmap.org/?mlat=<?=  $evenement->getLat() ?>&mlon=<?=  $evenement->getLng() ?>#map=17/<?= $evenement->getLat() ?>/<?= $evenement->getLng() ?>">
                                                    Ouvrir dans OpenStreetMap
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>

                                        <?php if ($estOrga): ?>
                                            <form method="POST" action="../src/traitement/suppEvenement.php">
                                                <input type="hidden" name="id_evenement" value="<?=  $evenement->getIdEvenement() ?>">
                                                <input type="hidden" name="titre" value="<?= $evenement->getTitre() ?>">
                                                <input type="hidden" name="nbr_places" value="<?= $evenement->getNbrPlaces() ?>">
                                                <button class="btn btn-outline-danger">Supprimer</button>
                                            </form>
                                        <?php elseif ($peutSinscrire): ?>
                                            <form method="POST" action="../src/traitement/newParticipe.php">
                                                <input type="hidden" name="ref_utilisateur" value="<?=  $_SESSION['id_utilisateur'] ?>">
                                                <input type="hidden" name="ref_evenement" value="<?=  $evenement->getIdEvenement() ?>">
                                                <button class="btn btn-primary">S'inscrire</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($inscrit): ?>
                                            <form method="POST" action="../src/traitement/suppParticipe.php">
                                                <input type="hidden" name="id_evenement" value="<?=  $evenement->getIdEvenement() ?>">
                                                <input type="hidden" name="id_user" value="<?= $idUser ?>">
                                                <button class="btn btn-outline-danger">Se désinscrire</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal : modification -->
                        <div class="modal fade edit-modal" id="edit<?= $id ?>" tabindex="-1" aria-hidden="true"
                             data-lat="<?= $aPosition ? ($lat) : '' ?>" data-lng="<?= $aPosition ? ($lng) : '' ?>">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="min-w-0">
                                            <div class="eyebrow">Modifier l'évènement</div>
                                            <h5 class="modal-title"><?= $evenement->getTitre() ?></h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>

                                    <form method="POST" action="../src/traitement/modifierEvenement.php">
                                        <input type="hidden" name="id_evenement" value="<?= $evenement->getIdEvenement() ?>">

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nom de l'évènement</label>
                                                <input type="text" class="form-event" name="titre"
                                                       value="<?= $evenement->getTitre() ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-event" name="description" required><?= $evenement->getDescription() ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Lieu</label>
                                                <input type="text" class="form-event" name="lieu"
                                                       value="<?= $evenement->getLieu() ?>" readonly>
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
                                                           value="<?= $aPosition ? $lat : '' ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Longitude</label>
                                                    <input type="number" step="any" min="-360" max="360" class="form-event edit-lng" name="lng"
                                                           value="<?= $aPosition ? $lng : '' ?>">
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
                                                    <input type="number" class="form-event" name="nbr_places" min="<?= $nbInscrits ?>" max="350" step="1" value="<?= $evenement->getNbrPlaces() ?>" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Date de l'évènement</label>
                                                    <input type="date" min="<?= $demain ?>" class="form-event" name="date_evenement" value="<?= $evenement->getDateEvenement() ?>" required>
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

    <!--
        ====================================================================
        EXPLICATION DU JAVASCRIPT DE LA PAGE
        Ces scripts servent uniquement à gérer les CARTES (Leaflet + OpenStreetMap)
        dans les 3 types de fenêtres (modals) de la page :
          1) la modal "Proposer un évènement"  -> choisir un lieu sur une carte
          2) les modals "Aperçu"               -> afficher la carte de l'évènement
          3) les modals "Modifier"             -> déplacer le point de l'évènement
        Aucun script ne trie ou ne filtre la liste : c'est le PHP qui s'en occupe.
        ====================================================================
    -->

    <!-- Leaflet : bibliothèque qui dessine les cartes (objet global "L").
         Bootstrap JS : fait fonctionner les modals (et lance l'évènement "shown.bs.modal"). -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ================= 1) MODAL "PROPOSER UN ÉVÈNEMENT" ================= -->
    <script>
        // "map" = la carte, "marker" = le point rouge posé dessus.
        // Ils valent null tant que la carte n'a pas été créée.
        var map = null;
        var marker = null;

        // Pose (ou déplace) le marqueur aux coordonnées données
        // et copie ces coordonnées dans les champs cachés envoyés au formulaire.
        function placerMarqueur(lat, lng) {
            if (marker) {
                // Le marqueur existe déjà : on le déplace simplement
                marker.setLatLng([lat, lng]);
            } else {
                // Premier clic : on crée le marqueur et on l'ajoute à la carte
                marker = L.marker([lat, lng]).addTo(map);
            }
            document.getElementById('lat').value = lat;   // champ caché "lat"
            document.getElementById('lng').value = lng;   // champ caché "lng"
        }

        // À partir de coordonnées, retrouve l'adresse écrite (géocodage inverse)
        // grâce au service gratuit Nominatim, puis la met dans le champ "lieu".
        function remplirLieu(lat, lng) {
            var champLieu = document.querySelector('input[name="lieu"]');
            champLieu.placeholder = "Recherche de l'adresse...";

            // fetch = requête vers Nominatim, qui répond en JSON
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&accept-language=fr&lat=' + lat + '&lon=' + lng)
                .then(function (r) { return r.json(); })          // on lit la réponse comme du JSON
                .then(function (data) {
                    // display_name = l'adresse complète trouvée
                    if (data && data.display_name) {
                        champLieu.value = data.display_name;
                    }
                })
                .catch(function () {
                    // En cas d'erreur réseau, on retire simplement le message d'attente
                    champLieu.placeholder = "";
                });
        }

        // L'inverse : à partir d'une adresse tapée, trouve les coordonnées (géocodage)
        // et place le marqueur dessus.
        function rechercher() {
            var q = document.getElementById('recherche').value.trim();
            if (!q) return;   // champ vide : on ne fait rien

            // encodeURIComponent protège les espaces et caractères spéciaux dans l'URL
            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q))
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.length === 0) {
                        alert("Adresse introuvable.");
                        return;
                    }
                    var lat = parseFloat(data[0].lat);   // texte -> nombre
                    var lng = parseFloat(data[0].lon);
                    map.setView([lat, lng], 17);          // centre la carte (17 = zoom proche)
                    placerMarqueur(lat, lng);
                    // On remplit aussi le champ "lieu" avec l'adresse trouvée
                    document.querySelector('input[name="lieu"]').value = data[0].display_name;
                });
        }

        // La carte est créée seulement quand la modal est AFFICHÉE ("shown.bs.modal").
        // Pourquoi ? Une carte créée dans un élément caché n'a pas de taille et s'afficherait mal.
        document.getElementById('addModal').addEventListener('shown.bs.modal', function () {
            if (!map) {   // on ne crée la carte qu'une seule fois
                // Centre de départ : Paris (latitude 48.8566, longitude 2.3522), zoom 12
                map = L.map('map').setView([48.8566, 2.3522], 12);

                // Fond de carte OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Un clic sur la carte : on place le point et on retrouve l'adresse
                map.on('click', function (e) {
                    placerMarqueur(e.latlng.lat, e.latlng.lng);
                    remplirLieu(e.latlng.lat, e.latlng.lng);
                });
            }
            // invalidateSize() dit à Leaflet de recalculer la taille de la carte
            // (la petite pause laisse finir l'animation d'ouverture de la modal).
            setTimeout(function () { map.invalidateSize(); }, 100);
        });

        // Bouton "Rechercher" : lance la recherche d'adresse
        document.getElementById('btnRecherche').addEventListener('click', rechercher);

        // Touche Entrée dans le champ de recherche : lance aussi la recherche.
        // preventDefault() empêche Entrée d'envoyer tout le formulaire par erreur.
        document.getElementById('recherche').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                rechercher();
            }
        });
    </script>

    <!-- ================= 2) MODALS "APERÇU" (une par évènement) ================= -->
    <script>
        // Il y a une modal d'aperçu par évènement : on traite chacune avec forEach.
        document.querySelectorAll('.preview-modal').forEach(function (modal) {
            var carte = null;   // la carte de CETTE modal (propre à chaque évènement)

            modal.addEventListener('shown.bs.modal', function () {
                // Les coordonnées sont écrites par PHP dans data-lat / data-lng de la modal
                var lat = parseFloat(modal.dataset.lat);
                var lng = parseFloat(modal.dataset.lng);
                var div = modal.querySelector('.map-preview');   // l'élément qui contiendra la carte

                // Pas de carte, ou pas de coordonnées valides (isNaN = "n'est pas un nombre") : on arrête
                if (!div || isNaN(lat) || isNaN(lng)) return;

                if (!carte) {   // création unique, à la première ouverture
                    carte = L.map(div).setView([lat, lng], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(carte);
                    L.marker([lat, lng]).addTo(carte);   // point fixe : lecture seule
                }
                setTimeout(function () { carte.invalidateSize(); }, 100);
            });
        });
    </script>

    <!-- Leaflet est chargé une 2e fois ci-dessous : c'est inutile (déjà chargé plus haut)
         et la feuille de style devrait être dans le <head>. Ça fonctionne quand même. -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>  <!-- idéalement dans le <head> -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- ================= 3) MODALS "MODIFIER" (une par évènement) ================= -->
    <script>
        document.querySelectorAll('.edit-modal').forEach(function (modal) {
            // Variables propres à cette modal : sa carte et son marqueur
            var carte = null, marqueur = null;
            // Champs du formulaire de CETTE modal (on cherche à l'intérieur de "modal")
            var champLat = modal.querySelector('.edit-lat');
            var champLng = modal.querySelector('.edit-lng');
            var champLieu = modal.querySelector('input[name="lieu"]');

            // Place ou déplace le marqueur ET met à jour les champs latitude/longitude
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
                // Position actuelle de l'évènement (écrite par PHP dans data-lat / data-lng)
                var lat = parseFloat(modal.dataset.lat);
                var lng = parseFloat(modal.dataset.lng);
                var aPosition = !isNaN(lat) && !isNaN(lng);   // vrai si l'évènement a déjà un point

                if (!carte) {   // création unique de la carte
                    // Si l'évènement a un point : on centre dessus (zoom 16).
                    // Sinon : on centre sur Paris (zoom 12).
                    carte = L.map(modal.querySelector('.edit-map'))
                        .setView(aPosition ? [lat, lng] : [48.8566, 2.3522], aPosition ? 16 : 12);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(carte);

                    // S'il y a déjà une position, on affiche le marqueur dessus
                    if (aPosition) placer(lat, lng);

                    // Clic sur la carte : met à jour les champs et le lieu
                    carte.on('click', function (e) {
                        placer(e.latlng.lat, e.latlng.lng);

                        // Retrouve l'adresse du nouveau point (même principe que remplirLieu)
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
                    // "change" se déclenche quand on quitte le champ après l'avoir modifié
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