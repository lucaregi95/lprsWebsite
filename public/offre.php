<?php


session_start();
require_once "../bdd/bdd.php";
require_once "../src/model/Offre.php";
require_once "../src/repository/OffreRepository.php";
require_once __DIR__ . "/../src/repository/EntrepriseRepository.php";
require_once "../src/repository/OffreUtilisateurRepository.php";
require_once "../src/model/OffreUtilisateur.php";

$offreRepository = new OffreRepository();
$offres = $offreRepository->getAllOffres();
$tabEntreprise = (new EntrepriseRepository())->getAllEntreprises();

$offreUtilisateurRepository = new OffreUtilisateurRepository();

$idUser=$_SESSION['id_utilisateur'];

$connexionBdd = (new Bdd())->getConnexionBdd();


$sql="SELECT role FROM v_utilisateurwithrole WHERE id_utilisateur=:id";
$req = $connexionBdd->prepare($sql);
$req->execute([':id'=>$idUser]);
$result = $req->fetch(pdo::FETCH_ASSOC);
$vueRole=$result['role'];



function h($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}


// Nom des entreprises, indexé par id
$nomsEntreprises = [];
foreach ($tabEntreprise as $e) {
    $nomsEntreprises[$e->getIdEntreprise()] = $e->getNomEntreprise();
}

// Id d'entreprise d'une offre (selon le getter disponible dans le modèle Offre)
function refEntrepriseOffre($offre)
{
    foreach (['getRefEntreprise', 'getIdEntreprise', 'getEntreprise'] as $getter) {
        if (method_exists($offre, $getter)) {
            return $offre->$getter();
        }
    }
    return null;
}

// 1 = Ouvert, 2 = Fermé (comme dans le formulaire d'ajout)
function offreFermee($offre)
{
    return ((int) $offre->getEtat() === 2);
}

$nbOffres   = count($offres);
$nbOuvertes = 0;
foreach ($offres as $o) {
    if (!offreFermee($o)) {
        $nbOuvertes++;
    }
}
$nbFermees = $nbOffres - $nbOuvertes;

// Statut de l'utilisateur pour chaque offre (null = rien, 1 = a postulé, 2 = gère l'offre)
$statuts = [];
foreach ($offres as $id => $o) {
    $p = $offreUtilisateurRepository->getOffreUtilisateur($idUser, $o->getIdOffre());
    $statuts[$id] = ($p == null) ? null : $p->getEstOrga();
}

// ---- Tri et filtres (envoyés en GET par le formulaire de l'aside) ----
$typesPossibles    = ['Stage', 'Alternance', 'Job étudiant'];
$q                 = mb_strtolower(trim((string) ($_GET['q'] ?? '')));
$tri               = (string) ($_GET['tri'] ?? 'defaut');
$typesChoisis      = array_values(array_intersect($typesPossibles, (array) ($_GET['types'] ?? [])));
$salaireMin        = (isset($_GET['salaire_min']) && $_GET['salaire_min'] !== '') ? (float) $_GET['salaire_min'] : null;
$entrepriseChoisie = (string) ($_GET['entreprise'] ?? '');
$afficherFermees   = isset($_GET['afficher_fermees']);
$filtrePostule     = isset($_GET['postule']);
$filtreMes         = isset($_GET['mes']);

$offres = array_filter($offres, function ($o, $id) use ($q, $typesChoisis, $salaireMin, $entrepriseChoisie, $afficherFermees, $filtrePostule, $filtreMes, $statuts, $nomsEntreprises) {
    $ref = refEntrepriseOffre($o);
    $nomEnt = isset($nomsEntreprises[$ref]) ? $nomsEntreprises[$ref] : '';

    if ($q !== '' && mb_strpos(mb_strtolower($o->getTitre() . ' ' . $o->getMission() . ' ' . $o->getDescription() . ' ' . $nomEnt), $q) === false) return false;
    if ($typesChoisis && !in_array($o->getTypeOffre(), $typesChoisis, true)) return false;
    if ($salaireMin !== null && (float) $o->getSalaire() < $salaireMin) return false;
    if ($entrepriseChoisie !== '' && (string) $ref !== $entrepriseChoisie) return false;
    if (!$afficherFermees && offreFermee($o)) return false;
    if ($filtrePostule && $statuts[$id] != 1) return false;
    if ($filtreMes && $statuts[$id] != 2) return false;
    return true;
}, ARRAY_FILTER_USE_BOTH);

$comparateurs = [
        'salaire-desc' => function ($a, $b) { return (float) $b->getSalaire() <=> (float) $a->getSalaire(); },
        'salaire-asc'  => function ($a, $b) { return (float) $a->getSalaire() <=> (float) $b->getSalaire(); },
        'titre'        => function ($a, $b) { return strcasecmp($a->getTitre(), $b->getTitre()); },
        'type'         => function ($a, $b) { return strcasecmp($a->getTypeOffre(), $b->getTypeOffre()); },
        'ouvertes'     => function ($a, $b) { return (int) offreFermee($a) <=> (int) offreFermee($b); },
];
if (isset($comparateurs[$tri])) {
    $cmp = $comparateurs[$tri];
    uasort($offres, function ($a, $b) use ($cmp) {
        return $cmp($a, $b) ?: ($a->getIdOffre() <=> $b->getIdOffre());
    });
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

    <!-- Modal : publier une offre -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalTitre" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <div class="eyebrow">Nouvelle offre</div>
                        <h5 class="modal-title" id="addModalTitre">Publier une offre</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form method="POST" action="../src/traitement/newOffre.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="add-titre">Nom de l'offre</label>
                            <input type="text" class="form-event" id="add-titre" name="titre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-event" id="description" name="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="add-mission">Mission</label>
                            <input type="text" class="form-event" id="add-mission" name="mission" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="add-salaire">Salaire (€/mois)</label>
                                <input type="number" class="form-event" id="add-salaire" name="salaire" min="0" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="add-type">Type d'offre</label>
                                <select class="form-event" id="add-type" name="type_offre" required>
                                    <option value="Stage">Stage</option>
                                    <option value="Alternance">Alternance</option>
                                    <option value="Job étudiant">Job étudiant</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="add-etat">État</label>
                                <select class="form-event" id="add-etat" name="etat" required>
                                    <option value="1">Ouvert</option>
                                    <option value="2">Fermé</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="ref_entreprise">Entreprise</label>
                                <select class="form-event" name="ref_entreprise" id="ref_entreprise" required>
                                    <?php foreach ($tabEntreprise as $entreprise) { ?>
                                        <option value="<?= (int) $entreprise->getIdEntreprise() ?>"><?= h($entreprise->getNomEntreprise()) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Publier l'offre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="box mb-3">
                <h6>Statistiques sur les offres</h6>
                <div class="d-flex flex-wrap gap-1">
                    <span class="tag"><?= $nbOuvertes ?> ouverte<?= $nbOuvertes > 1 ? 's' : '' ?></span>
                    <span class="tag tag-full"><?= $nbFermees ?> fermée<?= $nbFermees > 1 ? 's' : '' ?></span>
                </div>
            </div>

            <form method="GET" action="offre.php" id="filtres" class="box mb-3 filter-box">
                <h6 class="mb-3">Trier et filtrer</h6>

                <label class="form-label" for="tri">Trier par</label>
                <select id="tri" name="tri" class="form-select form-select-sm mb-3">
                    <?php foreach (['defaut' => 'Ordre par défaut', 'salaire-desc' => 'Salaire : le plus élevé', 'salaire-asc' => 'Salaire : le moins élevé', 'titre' => 'Nom (A → Z)', 'type' => "Type d'offre", 'ouvertes' => 'Ouvertes en premier'] as $val => $lib): ?>
                        <option value="<?= $val ?>" <?= $tri === $val ? 'selected' : '' ?>><?= h($lib) ?></option>
                    <?php endforeach; ?>
                </select>

                <span class="form-label">Type d'offre</span>
                <div class="mb-3">
                    <?php foreach ($typesPossibles as $k => $type): ?>
                        <div class="form-check small-t">
                            <input class="form-check-input" type="checkbox" name="types[]" id="t-<?= $k ?>" value="<?= h($type) ?>" <?= in_array($type, $typesChoisis, true) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="t-<?= $k ?>"><?= h($type) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <label class="form-label" for="f-salaire">Salaire minimum (€/mois)</label>
                <input type="number" min="0" step="50" id="f-salaire" name="salaire_min" class="form-control form-control-sm mb-3"
                       placeholder="Ex : 800" value="<?= $salaireMin !== null ? h($salaireMin) : '' ?>">

                <?php if (!empty($nomsEntreprises)): ?>
                    <label class="form-label" for="f-entreprise">Entreprise</label>
                    <select id="f-entreprise" name="entreprise" class="form-select form-select-sm mb-3">
                        <option value="">Toutes</option>
                        <?php foreach ($nomsEntreprises as $idEnt => $nomEnt): ?>
                            <option value="<?= (int) $idEnt ?>" <?= (string) $idEnt === $entrepriseChoisie ? 'selected' : '' ?>><?= h($nomEnt) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <div class="form-check small-t mb-1">
                    <input class="form-check-input" type="checkbox" name="afficher_fermees" id="f-fermees" <?= $afficherFermees ? 'checked' : '' ?>>
                    <label class="form-check-label" for="f-fermees">Afficher les offres fermées</label>
                </div>
                <div class="form-check small-t mb-1">
                    <input class="form-check-input" type="checkbox" name="postule" id="f-postule" <?= $filtrePostule ? 'checked' : '' ?>>
                    <label class="form-check-label" for="f-postule">Offres où j'ai postulé</label>
                </div>
                <div class="form-check small-t mb-3">
                    <input class="form-check-input" type="checkbox" name="mes" id="f-mes" <?= $filtreMes ? 'checked' : '' ?>>
                    <label class="form-check-label" for="f-mes">Offres que je gère</label>
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100">Appliquer</button>
                <a href="offre.php" class="btn btn-outline-secondary btn-sm w-100 mt-2">Réinitialiser</a>
            </form>
        </aside>

        <div class="col-lg-9">
            <div class="input-group input-group-sm mb-3">
                <input class="form-control" form="filtres" type="search" name="q" value="<?= h($_GET['q'] ?? '') ?>" placeholder="Rechercher une offre (nom, mission, description)"/>
                <button class="btn btn-outline-primary" form="filtres" type="submit">Rechercher</button>
            </div>
            <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h5 class="mb-0">Offres disponibles</h5>
                <span class="small-t"><?= count($offres) ?> offre<?= count($offres) > 1 ? 's' : '' ?></span>
            </div>

            <?php if (empty($offres)): ?>
                <p class="muted"><?= $nbOffres === 0 ? 'Aucune offre pour le moment.' : 'Aucune offre ne correspond à ces critères.' ?></p>
            <?php endif; ?>

            <div id="liste-offres">
                <?php foreach ($offres as $id => $offre): ?>
                    <?php
                    $Yparticipe = $statuts[$id];

                    $ferme = offreFermee($offre);
                    $refEnt = refEntrepriseOffre($offre);
                    $nomEnt = ($refEnt !== null && isset($nomsEntreprises[$refEnt])) ? $nomsEntreprises[$refEnt] : '';
                    $salaire = number_format((float) $offre->getSalaire(), 0, ',', ' ');

                    $estGere       = ($Yparticipe == 2);
                    $peutPostuler  = (!$ferme && !$estGere && $Yparticipe == null && $vueRole === "etudiant");
                    $aPostule      = (!$ferme && !$estGere && $vueRole === "etudiant" && $Yparticipe == 1);
                    $peutModifier  = ($estGere || !$ferme);
                    ?>

                    <!-- Card offre -->
                    <div class="offer-item">
                        <article class="offer-card <?= $ferme ? 'is-closed' : '' ?>">
                            <div class="logo-sq">
                                <i class="bi bi-briefcase"></i>
                            </div>

                            <div class="flex-grow-1 min-w-0">
                                <div class="event-tags">
                                    <span class="tag"><?= h($offre->getTypeOffre()) ?></span>
                                    <?php if ($ferme): ?>
                                        <span class="tag tag-full">Fermé</span>
                                    <?php else: ?>
                                        <span class="tag tag-ok">Ouvert</span>
                                    <?php endif; ?>
                                    <?php if ($Yparticipe == 1): ?>
                                        <span class="tag tag-warn"><i class="bi bi-send-check"></i> Candidature envoyée</span>
                                    <?php endif; ?>
                                </div>
                                <h6 class="event-title"><?= h($offre->getTitre()) ?></h6>
                                <div class="offer-meta">
                                    <?php if ($nomEnt !== ''): ?>
                                        <span><i class="bi bi-building"></i> <?= h($nomEnt) ?></span>
                                    <?php endif; ?>
                                    <span><i class="bi bi-cash-coin"></i> <?= $salaire ?> €/mois</span>
                                </div>
                                <p class="event-desc mt-2 mb-0"><?= h($offre->getMission()) ?></p>
                            </div>

                            <div class="offer-actions">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#preview<?= $id ?>">
                                    Aperçu
                                </button>

                                <?php if ($peutPostuler): ?>
                                    <form method="POST" action="../src/traitement/newOffreUtilisateur.php">
                                        <input type="hidden" name="ref_utilisateur" value="<?= (int) $idUser ?>">
                                        <input type="hidden" name="ref_offre" value="<?= (int) $offre->getIdOffre() ?>">
                                        <button class="btn btn-primary btn-sm w-100">Postuler</button>
                                    </form>
                                <?php elseif ($aPostule): ?>
                                    <form method="POST" action="../src/traitement/suppParticipe.php">
                                        <input type="hidden" name="ref_offre" value="<?= (int) $offre->getIdOffre() ?>">
                                        <input type="hidden" name="ref_utilisateur" value="<?= (int) $idUser ?>">
                                        <button class="btn btn-outline-danger btn-sm w-100">Retirer</button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($peutModifier): ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#edit<?= $id ?>">
                                        Modifier
                                    </button>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>

                    <!-- Modal : aperçu -->
                    <div class="modal fade preview-modal" id="preview<?= $id ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="min-w-0">
                                        <div class="eyebrow">Aperçu de l'offre</div>
                                        <h5 class="modal-title"><?= h($offre->getTitre()) ?></h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="event-tags mb-3">
                                        <span class="tag"><?= h($offre->getTypeOffre()) ?></span>
                                        <?php if ($ferme): ?>
                                            <span class="tag tag-full">Fermé</span>
                                        <?php else: ?>
                                            <span class="tag tag-ok">Ouvert</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="info-grid">
                                        <div class="info-item">
                                            <i class="bi bi-cash-coin"></i>
                                            <div>
                                                <span class="info-label">Salaire</span>
                                                <?= $salaire ?> €/mois
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <i class="bi bi-briefcase"></i>
                                            <div>
                                                <span class="info-label">Type d'offre</span>
                                                <?= h($offre->getTypeOffre()) ?>
                                            </div>
                                        </div>
                                        <?php if ($nomEnt !== ''): ?>
                                            <div class="info-item info-wide">
                                                <i class="bi bi-building"></i>
                                                <div>
                                                    <span class="info-label">Entreprise</span>
                                                    <?= h($nomEnt) ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <span class="info-label">Mission</span>
                                        <p class="mb-0 event-full-desc"><?= nl2br(h($offre->getMission())) ?></p>
                                    </div>

                                    <div>
                                        <span class="info-label">Description</span>
                                        <p class="mb-0 event-full-desc"><?= nl2br(h($offre->getDescription())) ?></p>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>

                                    <?php if ($estGere): ?>
                                        <form method="POST" action="../src/traitement/suppOffre.php">
                                            <input type="hidden" name="id_offre" value="<?= (int) $offre->getIdOffre() ?>">
                                            <input type="hidden" name="titre" value="<?= h($offre->getTitre()) ?>">
                                            <button class="btn btn-danger">Supprimer</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($peutPostuler): ?>
                                        <form method="POST" action="../src/traitement/newOffreUtilisateur.php">
                                            <input type="hidden" name="ref_utilisateur" value="<?= (int) $idUser ?>">
                                            <input type="hidden" name="ref_offre" value="<?= (int) $offre->getIdOffre() ?>">
                                            <button class="btn btn-primary">Postuler</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal : modification -->
                    <div class="modal fade edit-modal" id="edit<?= $id ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="min-w-0">
                                        <div class="eyebrow">Modifier l'offre</div>
                                        <h5 class="modal-title"><?= h($offre->getTitre()) ?></h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>

                                <form method="POST" action="../src/traitement/modifierOffre.php">
                                    <input type="hidden" name="id_offre" value="<?= (int) $offre->getIdOffre() ?>">

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nom de l'offre</label>
                                            <input type="text" class="form-event" name="titre"
                                                   value="<?= h($offre->getTitre()) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-event" name="description" required><?= h($offre->getDescription()) ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mission</label>
                                            <input type="text" class="form-event" name="mission"
                                                   value="<?= h($offre->getMission()) ?>" required>
                                        </div>

                                        <div class="row g-3 mb-3">
                                            <div class="col-sm-6">
                                                <label class="form-label">Salaire (€/mois)</label>
                                                <input type="number" class="form-event" name="salaire" min="0"
                                                       value="<?= h($offre->getSalaire()) ?>" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Type d'offre</label>
                                                <select class="form-event" name="type_offre" required>
                                                    <?php foreach (['Stage', 'Alternance', 'Job étudiant'] as $type): ?>
                                                        <option value="<?= h($type) ?>" <?= $offre->getTypeOffre() === $type ? 'selected' : '' ?>>
                                                            <?= h($type) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label class="form-label">État</label>
                                                <select class="form-event" name="etat" required>
                                                    <option value="1" <?= !$ferme ? 'selected' : '' ?>>Ouvert</option>
                                                    <option value="2" <?= $ferme ? 'selected' : '' ?>>Fermé</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">Entreprise</label>
                                                <select class="form-event" name="ref_entreprise" required>
                                                    <?php foreach ($tabEntreprise as $entreprise) { ?>
                                                        <option value="<?= (int) $entreprise->getIdEntreprise() ?>" <?= ($refEnt !== null && (string) $refEnt === (string) $entreprise->getIdEntreprise()) ? 'selected' : '' ?>><?= h($entreprise->getNomEntreprise()) ?></option>
                                                    <?php } ?>
                                                </select>
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