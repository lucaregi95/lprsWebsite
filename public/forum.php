<?php
require_once "../bdd/bdd.php";
require_once "../src/model/post.php";
require_once "../src/repository/postRepository.php";
session_start();

$bdd = new Bdd();
$connexionBdd = $bdd->getConnexionBdd();

if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();

    $id_utilisateur = $_SESSION['id_utilisateur'];

    switch ($role) {
        case 'etudiant':

            break;
        case 'partenaire':

            break;
        case 'alumni':

            break;
        default:

    }
}

if (isset($_GET['categorie_post'])) {
    $categorie = $_GET['categorie_post'];
} else {
    $categorie = '';
}
if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
} else {
    $recherche = '';
}

// "WHERE 1=1" est une astuce pour pouvoir ajouter des "AND" dynamiquement sans condition initiale
$sql = " SELECT post.id_post, post.titre, post.date_post, post.categorie_post, utilisateur.nom,(SELECT COUNT(*) FROM reponse WHERE reponse.ref_post = post.id_post) as nb_reponses FROM post INNER JOIN utilisateur ON post.ref_utilisateur = utilisateur.id_utilisateur WHERE 1=1 ";


$tableau = [];

if ($categorie != '') {
    $sql = $sql . " AND post.categorie_post LIKE :categorie_post";
    $tableau['categorie_post'] = '%' . $categorie . '%';
}

if ($recherche != '') {
    $sql = $sql . " AND (post.titre LIKE :recherche OR post.contenu LIKE :recherche)";
    $tableau['recherche'] = '%' . $recherche . '%';
}

$sql = $sql . " ORDER BY post.date_post DESC";

$req = $connexionBdd->prepare($sql);
$req->execute($tableau);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);


$categories = ['Général', 'Alumni', 'Étudiant','Entreprise'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        Campus - Forum
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
    <style>
        :root { --accent:#e11d48; --accent-dark:#be123c; --accent-soft:#fff1f2; --ink:#1f2937; --muted:#6b7280; --line:#e5e7eb; }
        body { background:#f8fafc; color:var(--ink); font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }

        /* Navbar */
        .navbar { background:#fff; border-bottom:1px solid var(--line); box-shadow:0 1px 8px rgba(0,0,0,.04); }
        .navbar .logo { height:38px; }
        .navbar .nav-link { color:var(--ink); font-weight:500; border-radius:8px; padding:.4rem .8rem; }
        .navbar .nav-link:hover, .navbar .nav-link.active { background:var(--accent-soft); color:var(--accent); }
        .avatar { background:var(--accent); color:#fff; width:36px; height:36px; border-radius:50%;
            display:inline-flex; align-items:center; justify-content:center; font-weight:600; font-size:.8rem; text-transform:uppercase; }

        /* Hero */
        .hero { background:linear-gradient(135deg,#e11d48,#9f1239); color:#fff; padding:3rem 0; }
        .hero h1 { font-weight:800; margin:0; }
        .hero p { opacity:.9; margin:.4rem 0 0; }
        .hero .eyebrow { text-transform:uppercase; letter-spacing:.12em; font-size:.75rem; opacity:.8; }

        /* Boîtes latérales */
        .box { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.1rem; box-shadow:0 2px 10px rgba(0,0,0,.04); }
        .box h6 { font-weight:700; margin-bottom:.8rem; }
        .box .form-control, .box .form-select { border-radius:10px; }
        .form-control:focus, .form-select:focus { border-color:var(--accent); box-shadow:0 0 0 .2rem rgba(225,29,72,.15); }
        .btn-primary { background:var(--accent); border-color:var(--accent); border-radius:10px; font-weight:600; }
        .btn-primary:hover { background:var(--accent-dark); border-color:var(--accent-dark); }

        /* Catégories */
        .small-t { color:var(--muted); padding:.35rem .6rem; border-radius:8px; display:block; }
        .small-t:hover, .small-t.fw-bold { background:var(--accent-soft); color:var(--accent); }

        /* Recherche + onglets */
        main .form-control-sm { border-radius:12px; padding:.6rem 1rem; border:1px solid var(--line); }
        .tabs a { display:inline-block; padding:.6rem 1rem; color:var(--muted); text-decoration:none; border-bottom:3px solid transparent; font-weight:500; }
        .tabs a.on, .tabs a:hover { color:var(--accent); border-bottom-color:var(--accent); }

        /* Tableau */
        .card.border-danger { border:1px solid var(--line) !important; border-radius:16px !important; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.05) !important; background:#fff; }
        .table-danger { --bs-table-bg:#fafafa; --bs-table-color:var(--muted); }
        .table thead th { font-size:.75rem; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--line); }
        .table-hover tbody tr:hover { --bs-table-hover-bg:var(--accent-soft); }
        .badge.bg-danger { background:var(--accent-soft) !important; color:var(--accent); font-weight:600; }
        .badge.bg-light { background:#f3f4f6 !important; border:none !important; font-weight:500; }

        /* Footer */
        footer { margin-top:3rem; padding:1.5rem 0; background:#fff; border-top:1px solid var(--line); color:var(--muted); font-size:.9rem; }
        footer a { color:var(--muted); text-decoration:none; margin-left:1rem; }
        footer a:hover { color:var(--accent); }
    </style>
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
                <li class="nav-item"><a class="nav-link" href="accueil.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="evenement.php">Évènement</a></li>
                <li class="nav-item"><a class="nav-link" href="offre.php">Offre</a></li>
                <li class="nav-item"><a class="nav-link" href="alumni.php">Alumni</a></li>
                <li class="nav-item"><a class="nav-link" href="entreprise.php">Entreprises</a></li>
                <li class="nav-item"><a class="nav-link active" href="forum.php">Forum</a></li>
                <?php if(isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin') { ?>
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
    <div class="container d-flex justify-content-between align-items-end">
        <div>
            <div class="eyebrow">
                Campus · Forum
            </div>
            <h1>
                Forum
            </h1>
            <p>
                Pose tes questions, partage tes idées et échange avec la communauté.
            </p>
        </div>

    </div>
</header>
<main class="container mt-4">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="box mb-3">
                <h6>
                    Nouveau post
                </h6>
                <form action="../src/traitement/newPost.php" method="post">
                    <input class="form-control form-control-sm mb-2" type="text" name="titre" placeholder="Titre" required/>
                    <select class="form-select form-select-sm mb-2" name="categorie_post" required>
                        <option value="">Catégorie…</option>
                        <?php foreach ($categories as $cat) { ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                        <?php } ?>
                    </select>
                    <textarea class="form-control form-control-sm mb-2" name="contenu" placeholder="Écris ton message…" rows="4" required></textarea>
                    <button class="btn btn-primary btn-sm w-100" type="submit">
                        Publier
                    </button>
                </form>
            </div>

            <div class="box">
                <h6>
                    Catégories
                </h6>
                <div class="d-flex flex-column gap-1">
                    <a class="small-t text-decoration-none <?= $categorie == '' ? 'fw-bold' : '' ?>" href="forum.php">
                        Toutes
                    </a>
                    <?php foreach ($categories as $cat) { ?>
                        <a class="small-t text-decoration-none <?= $categorie == $cat ? 'fw-bold' : '' ?>" href="forum.php?categorie_post=<?= urlencode($cat) ?>">
                            <?= htmlspecialchars($cat) ?>
                        </a>
                    <?php } ?>
                </div>
            </div>

        </aside>
        <div class="col-lg-9">
            <form method="get" action="forum.php" class="mb-3">
                <?php if ($categorie != '') { ?>
                    <input type="hidden" name="categorie_post" value="<?= htmlspecialchars($categorie) ?>"/>
                <?php } ?>
                <input class="form-control form-control-sm" name="recherche" value="<?= htmlspecialchars($recherche) ?>" placeholder="Rechercher un post"/>
            </form>
            <div class="tabs border-bottom mb-3">
                <a class="on" href="#">
                    Récents
                </a>
                <a href="#">
                    Sans réponse
                </a>
                <a href="#">
                    Mes posts
                </a>
            </div>

            <div class="card border-danger border-3 shadow-sm rounded-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-danger">
                        <tr>
                            <th class="py-3">Sujet</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Auteur</th>
                            <th class="py-3">Catégorie</th>
                            <th class="text-center py-3">Réponses</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(empty($sujets)){ ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted fw-semibold mb-0">Aucun sujet trouvé</p>
                                    <small class="text-muted">Essayez de modifier vos filtres ou créez un nouveau sujet</small>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach($sujets as $sujet){ ?>
                                <!-- onclick sur la ligne entière : redirige vers la page du sujet -->
                                <tr class="cursor-pointer" onclick="window.location='sujet.php?id=<?= $sujet['id_post'] ?>'" style="cursor:pointer;">
                                    <td class="py-3">
                                        <span class="fw-semibold"><?= htmlspecialchars($sujet['titre']) ?></span>
                                    </td>
                                    <!-- strtotime convertit la date SQL en timestamp, date() la formate en français -->
                                    <td class="py-3 text-muted"><?= date('d/m/Y', strtotime($sujet['date_post'])) ?></td>
                                    <td class="py-3">
                                <span class="badge bg-light text-dark border">
                                    <?= htmlspecialchars($sujet['nom']) ?>
                                </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-danger rounded-pill px-3"><?= htmlspecialchars($sujet['categorie_post']) ?></span>
                                    </td>
                                    <td class="text-center py-3">
                                        <span class="badge bg-danger rounded-pill fs-6 px-3"><?= $sujet['nb_reponses'] ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
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
</body>
</html>