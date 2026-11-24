<?php
session_start();
require_once "../bdd/bdd.php";

if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();
}

$bdd = new Bdd();
$connexionBdd = $bdd->getConnexionBdd();

//$sql = "SELECT p.id_post, p.titre, p.date_post, p.categorie_post, (SELECT COUNT(*) FROM reponse WHERE reponse.ref_post = p.id_post) AS nb_reponses FROM post p WHERE p.ref_utilisateur = :id_utilisateur ORDER BY p.date_post DESC";
//$req = $connexionBdd->prepare($sql);
//$req->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
//$sujets = $req->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(id_reponse) AS nb_reponses FROM reponse WHERE id_utilisateur = :id_utilisateur ORDER BY p.date_post DESC";
$req = $connexionBdd->prepare($sql);
$req->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT COUNT(id_post) AS nb_posts FROM post WHERE id_utilisateur = :id_utilisateur";


//$totalSujets = count($sujets);
//$totalReponses = array_sum(array_column($sujets, 'nb_reponses'));
//$sansReponse = count(array_filter($sujets, fn($s) => $s['nb_reponses'] == 0));
//$categoriesPresentes = array_unique(array_column($sujets, 'categorie_post'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>Campus - Mes sujets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>
    <style>
        :root { --accent: #1c66ce; --accent-dark: #0e36d8; --accent-soft:#fff1f2; --ink:#1f2937; --muted:#6b7280; --line:#e5e7eb; }
        body { background:#f8fafc; color:var(--ink); font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }

        .navbar { background:#fff; border-bottom:1px solid var(--line); box-shadow:0 1px 8px rgba(0,0,0,.04); }
        .navbar .logo { height:38px; }
        .navbar .nav-link { color:var(--ink); font-weight:500; border-radius:8px; padding:.4rem .8rem; }
        .navbar .nav-link:hover, .navbar .nav-link.active { background:var(--accent-soft); color:var(--accent); }
        .avatar { background:var(--accent); color:#fff; width:36px; height:36px; border-radius:50%;
            display:inline-flex; align-items:center; justify-content:center; font-weight:600; font-size:.8rem; text-transform:uppercase; }

        .hero { background:linear-gradient(135deg, #1d55e1, #12299f); color:#fff; padding:3rem 0; }
        .hero h1 { font-weight:800; margin:0; }
        .hero p { opacity:.9; margin:.4rem 0 0; }
        .hero .eyebrow { text-transform:uppercase; letter-spacing:.12em; font-size:.75rem; opacity:.8; }
        .btn-light-hero { background:#fff; color:var(--accent); border-radius:10px; font-weight:600; border:none; }
        .btn-light-hero:hover { background:var(--accent-soft); color:var(--accent-dark); }

        /* Statistiques */
        .stats { margin-top:-2rem; }
        .stat { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.1rem 1.25rem;
            box-shadow:0 2px 12px rgba(0,0,0,.05); display:flex; align-items:center; gap:1rem; height:100%; }
        .stat .icon { width:46px; height:46px; border-radius:12px; background:var(--accent-soft); color:var(--accent);
            display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
        .stat .num { font-size:1.6rem; font-weight:800; line-height:1; }
        .stat .lbl { color:var(--muted); font-size:.85rem; }

        /* Barre d'outils */
        .toolbar .form-control { border-radius:12px; padding:.6rem 1rem 0.6rem 2.5rem; border:1px solid var(--line); }
        .toolbar .form-control:focus { border-color:var(--accent); box-shadow:0 0 0 .2rem rgba(225,29,72,.15); }
        .search-wrap { position:relative; }
        .search-wrap i { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--muted); }
        .chip { border:1px solid var(--line); background:#fff; color:var(--muted); border-radius:999px;
            padding:.35rem .9rem; font-size:.85rem; font-weight:500; cursor:pointer; transition:.15s; }
        .chip:hover { border-color:var(--accent); color:var(--accent); }
        .chip.on { background:var(--accent); border-color:var(--accent); color:#fff; }

        /* Cartes de sujets */
        .sujet { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.1rem 1.25rem;
            display:flex; align-items:center; gap:1rem; text-decoration:none; color:inherit;
            box-shadow:0 2px 10px rgba(0,0,0,.04); transition:transform .15s, box-shadow .15s, border-color .15s; }
        .sujet:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(225,29,72,.10); border-color:#fecdd3; color:inherit; }
        .sujet .titre { font-weight:700; font-size:1.05rem; margin-bottom:.25rem; }
        .sujet .meta { color:var(--muted); font-size:.85rem; }
        .badge-cat { background:var(--accent-soft); color:var(--accent); font-weight:600; border-radius:999px; padding:.35rem .8rem; font-size:.75rem; }
        .rep { text-align:center; min-width:64px; padding:.5rem .7rem; border-radius:12px; background:#f3f4f6; }
        .rep .n { font-weight:800; font-size:1.2rem; line-height:1; }
        .rep .t { font-size:.7rem; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; }
        .rep.vide { background:#fffbeb; }
        .rep.vide .n { color:#b45309; }
        .arrow { color:var(--muted); font-size:1.2rem; }
        .sujet:hover .arrow { color:var(--accent); }

        /* État vide */
        .empty { background:#fff; border:2px dashed var(--line); border-radius:16px; padding:3.5rem 1rem; text-align:center; }
        .empty i { font-size:2.8rem; color:#fda4af; }

        .btn-primary { background:var(--accent); border-color:var(--accent); border-radius:10px; font-weight:600; }
        .btn-primary:hover { background:var(--accent-dark); border-color:var(--accent-dark); }

        footer { margin-top:3rem; padding:1.5rem 0; background:#fff; border-top:1px solid var(--line); color:var(--muted); font-size:.9rem; }

        @media (max-width:576px) {
            .sujet { flex-wrap:wrap; }
            .sujet .arrow { display:none; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="accueil.php"><img class="logo" src="img/logo.png" alt="LPRS"></a>
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
                <?php if (isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin') { ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Administration</a></li>
                <?php } ?>
            </ul>
            <div class="dropdown">
                <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                    <span class="avatar"><?= htmlspecialchars($_SESSION["prenom"][0] . $_SESSION["nom"][0]) ?></span>
                    <span class="small"><?= htmlspecialchars($_SESSION["prenom"] . " " . $_SESSION["nom"]) ?> <i class="bi bi-chevron-down"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<header class="hero pb-5">
    <div class="container d-flex justify-content-between align-items-end flex-wrap gap-3">
        <div>
            <div class="eyebrow">Campus · Forum</div>
            <h1>Mes sujets</h1>
            <p>Retrouve et suis tous les sujets que tu as publiés.</p>
        </div>
        <a class="btn btn-light-hero" href="forum.php"><i class="bi bi-arrow-left"></i> Retour au forum</a>
    </div>
</header>

<main class="container">
    <!-- Statistiques -->
    <div class="row g-3 stats">
        <div class="col-12 col-md-4">
            <div class="stat">
                <div class="icon"><i class="bi bi-chat-square-text"></i></div>
                <div><div class="num"><?= $totalSujets ?></div><div class="lbl">Sujets publiés</div></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat">
                <div class="icon"><i class="bi bi-reply"></i></div>
                <div><div class="num"><?= $totalReponses ?></div><div class="lbl">Réponses reçues</div></div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat">
                <div class="icon"><i class="bi bi-hourglass-split"></i></div>
                <div><div class="num"><?= $sansReponse ?></div><div class="lbl">Sans réponse</div></div>
            </div>
        </div>
    </div>

    <?php if (empty($sujets)) { ?>
        <div class="empty mt-4">
            <i class="bi bi-chat-square-dots"></i>
            <h5 class="fw-bold mt-3">Tu n'as encore publié aucun sujet</h5>
            <p class="text-muted">Pose une question ou partage une idée avec la communauté.</p>
            <a class="btn btn-primary" href="forum.php"><i class="bi bi-plus-lg"></i> Créer un sujet</a>
        </div>
    <?php } else { ?>

        <!-- Recherche + filtres -->
        <div class="toolbar mt-4 mb-3 d-flex flex-wrap align-items-center gap-3">
            <div class="search-wrap flex-grow-1">
                <i class="bi bi-search"></i>
                <input id="recherche" type="search" class="form-control" placeholder="Rechercher dans mes sujets…">
            </div>
            <div class="d-flex flex-wrap gap-2" id="filtres">
                <button type="button" class="chip on" data-cat="">Toutes</button>
                <?php foreach ($categoriesPresentes as $cat) { ?>
                    <button type="button" class="chip" data-cat="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
                <?php } ?>
            </div>
        </div>

        <!-- Liste -->
        <div class="d-flex flex-column gap-3" id="liste">
            <?php foreach ($sujets as $sujet) {
                $nb = (int)$sujet['nb_reponses']; ?>
                <a class="sujet"
                   href="sujet.php?id=<?= (int)$sujet['id_post'] ?>"
                   data-cat="<?= htmlspecialchars($sujet['categorie_post']) ?>"
                   data-titre="<?= htmlspecialchars(mb_strtolower($sujet['titre'])) ?>">
                    <div class="flex-grow-1">
                        <div class="titre"><?= htmlspecialchars($sujet['titre']) ?></div>
                        <div class="meta">
                            <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($sujet['date_post'])) ?>
                            <span class="mx-1">·</span>
                            <span class="badge-cat"><?= htmlspecialchars($sujet['categorie_post']) ?></span>
                        </div>
                    </div>
                    <div class="rep <?= $nb == 0 ? 'vide' : '' ?>">
                        <div class="n"><?= $nb ?></div>
                        <div class="t"><?= $nb > 1 ? 'réponses' : 'réponse' ?></div>
                    </div>
                    <i class="bi bi-chevron-right arrow"></i>
                </a>
            <?php } ?>
        </div>

        <div id="aucun" class="empty mt-3" style="display:none;">
            <i class="bi bi-search"></i>
            <p class="fw-semibold mt-3 mb-0">Aucun sujet ne correspond à ta recherche</p>
        </div>
    <?php } ?>
</main>

<footer>
    <div class="container">© 2026 Campus. Tous droits réservés.</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filtrage instantané (recherche + catégorie) côté navigateur
    const champ = document.getElementById('recherche');
    const filtres = document.querySelectorAll('#filtres .chip');
    const cartes = document.querySelectorAll('#liste .sujet');
    const aucun = document.getElementById('aucun');
    let categorieActive = '';

    function filtrer() {
        if (!champ) return;
        const q = champ.value.trim().toLowerCase();
        let visibles = 0;
        cartes.forEach(c => {
            const ok = (categorieActive === '' || c.dataset.cat === categorieActive)
                && c.dataset.titre.includes(q);
            c.style.display = ok ? '' : 'none';
            if (ok) visibles++;
        });
        aucun.style.display = visibles === 0 ? '' : 'none';
    }

    if (champ) champ.addEventListener('input', filtrer);
    filtres.forEach(btn => btn.addEventListener('click', () => {
        filtres.forEach(b => b.classList.remove('on'));
        btn.classList.add('on');
        categorieActive = btn.dataset.cat;
        filtrer();
    }));
</script>
</body>
</html>
