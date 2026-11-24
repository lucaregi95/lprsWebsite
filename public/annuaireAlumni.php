<?php
session_start();

if(!(isset($_SESSION['id_utilisateur']))){
    header('Location: connexion.php');
}else{



require_once __DIR__."/../bdd/bdd.php";
require_once __DIR__."/../src/model/Alumni.php";
require_once __DIR__."/../src/repository/AlumniRepository.php";
require_once __DIR__."/../src/repository/PromotionRepository.php";
require_once __DIR__."/../src/repository/EntrepriseRepository.php";
$rep = new AlumniRepository();
$alumnis=$rep->getAllAlumnis();
$promRep=new PromotionRepository();
$entRep=new EntrepriseRepository();

$promotions  = $promRep->getAllPromotions();
$entreprises = $entRep->getAllEntreprises();

$filtres = [
    'nom'        => trim($_GET['nom'] ?? ''),
    'promotion'  => $_GET['promotion'] ?? '',
    'entreprise' => $_GET['entreprise'] ?? '',
    'poste'      => trim($_GET['poste'] ?? ''),
];
$alumnisFiltre = $rep->getAlumnisFiltres($filtres);


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
                <li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'professeur'){ ?>
                    <li class="nav-item"><div class="dropdown">
                            <a class="nav-link text-decoration-none text-dark d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">Annuaires<i class="bi bi-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="annuaireAlumni.php">Alumnis</a></li>
                                <li><a class="dropdown-item" href="annuaireEtudiant.php">Etudiants</a></li>
                            </ul>
                        </div></li>
                <?php }if((isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin')||(isset($_SESSION['role']) && $_SESSION['statut_validation'] == 'gestionnaire')) { ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Administration</a></li>
                <?php } ?>
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
    <div class="container">
        <div class="eyebrow">LPRS · Accueil</div>
        <?php if(isset($_SESSION["id_utilisateur"])){?>
            <h1><?=$_SESSION["prenom"]?>, retrouvez l'annuaire des anciens élèves LPRS</h1>
        <?php }else{ ?>
            <h1>Recherchez les anciens élèves afin de créer du lien</h1>
        <?php }?>

        <p>Cet espace permet de rechercher, selon les filtres, des étudiants déjà passés par LPRS, afin de maintenir les relations.</p>

    </div>
</header>
<div class="container my-4">
    <div class="row g-4">

        <!-- Colonne filtres -->
        <aside class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 filtres-card">
                <div class="card-body p-4">
                    <h2 class="h6 fw-bold mb-3">
                        <i class="bi bi-funnel me-2"></i>Filtres
                    </h2>

                    <form method="get">
                        <div class="mb-3">
                            <label for="nom" class="form-label small text-muted">Nom ou prénom</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" id="nom" name="nom" class="form-control"
                                       placeholder="Rechercher..."
                                       value="<?= htmlspecialchars($filtres['nom']) ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="promotion" class="form-label small text-muted">Promotion</label>
                            <select id="promotion" name="promotion" class="form-select">
                                <option value="">Toutes</option>
                                <?php foreach ($promotions as $p) { ?>
                                    <option value="<?= $p->getIdPromotion() ?>" <?= $filtres['promotion'] == $p->getIdPromotion() ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p->getAnnee()) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="entreprise" class="form-label small text-muted">Entreprise</label>
                            <select id="entreprise" name="entreprise" class="form-select">
                                <option value="">Toutes</option>
                                <?php foreach ($entreprises as $e) { ?>
                                    <option value="<?= $e->getIdEntreprise() ?>" <?= $filtres['entreprise'] == $e->getIdEntreprise() ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($e->getNomEntreprise()) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="poste" class="form-label small text-muted">Poste occupé</label>
                            <input type="text" id="poste" name="poste" class="form-control"
                                   placeholder="Ex : développeur"
                                   value="<?= htmlspecialchars($filtres['poste']) ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>Filtrer
                            </button>
                            <a href="annuaireAlumni.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Colonne tableau -->
        <section class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body px-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-bold mb-0">Anciens élèves</h2>
                        <span class="badge text-bg-light"><?= count($alumnisFiltre) ?> résultat(s)</span>
                    </div>

                    <?php if (empty($alumnisFiltre)) { ?>
                        <p class="text-muted text-center my-4">Aucun alumni ne correspond à votre recherche.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="text-muted small">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Promotion</th>
                                    <th>Statut professionnel</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($alumnisFiltre as $a) { ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="avatar"><?= htmlspecialchars(mb_strtoupper(mb_substr($a->getPrenom(), 0, 1) . mb_substr($a->getNom(), 0, 1))) ?></span>
                                                <div>
                                                    <div class="fw-semibold"><?= htmlspecialchars($a->getPrenom() . " " . $a->getNom()) ?></div>
                                                    <div class="small text-muted"><?= htmlspecialchars($a->getEmail()) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="small">
                                            <?php
                                            $promA = $promRep->getPromotion($a->getRefPromotion());
                                            echo htmlspecialchars($promA->getAnnee());
                                            ?>
                                        </td>
                                        <td>
                                            <?php $entreprise = $entRep->getEntreprise($a->getRefEntreprise()); ?>
                                            <div class="fw-semibold"><?= htmlspecialchars($entreprise->getNomEntreprise()) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($a->getPosteOccupe()) ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>

<?php } ?>