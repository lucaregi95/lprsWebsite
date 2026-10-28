<?php

session_start();
if(!(isset($_SESSION['statut_validation']) || $_SESSION['statut_validation'] != 'admin')) {
    header("location:accueil.php");
    exit;
}else{

    require_once __DIR__."/../bdd/bdd.php";
    require_once __DIR__."/../src/model/VueUtilisateurRole.php";
    require_once __DIR__."/../src/repository/VueUtilisateurRoleRepository.php";

    $rep = new VueUtilisateurRoleRepository();
    $userAttente=$rep->getAllUtilisateurWithRolesEnAttente();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>LPRS - Administration</title>
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
                <li class="nav-item"><a class="nav-link" href="accueil.php">Accueil</a></li>

                <?php if(isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin') { ?>
                    <li class="nav-item"><a class="nav-link active" href="admin.php">Administration</a></li>
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
            <h1>Bonjour <?=$_SESSION["prenom"]?>, bienvenue sur ton espace administration LPRS.</h1>
        <?php }else{ ?>
            <h1>Créer votre compte ou connectez vous pour accéder a votre espace LPRS</h1>
        <?php }?>

        <p>Retrouvez ici la gestion des utilisateurs et d'autres éléments d'administration</p>
    </div>
</header>

<div class="row justify-content-center my-4">
    <div class="col-lg-8 col-xl-7">
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Utilisateurs en attente</h5>
                    <small class="text-muted">Comptes à valider</small>
                </div>
                <span class="badge bg-warning text-dark rounded-pill"><?= count($userAttente)." en attente" ?></span>
            </div>

            <div class="card-body px-4">
                <?php if (empty($userAttente)) { ?>
                    <p class="text-muted text-center my-4">Aucun utilisateur en attente.</p>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small">
                            <tr>
                                <th>Utilisateur</th>
                                <th>Date d'inscription</th>
                                <th>Statut de validation</th>
                                <th>Rôle</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($userAttente as $u) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar"><?= htmlspecialchars(mb_strtoupper(mb_substr($u->getPrenom(), 0, 1) . mb_substr($u->getNom(), 0, 1))) ?></span>
                                            <div>
                                                <div class="fw-semibold"><?= htmlspecialchars($u->getPrenom() . " " . $u->getNom()) ?></div>
                                                <div class="small text-muted"><?= htmlspecialchars($u->getEmail()) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($u->getDateInscription()) ?></td>
                                    <td><span class="badge bg-warning text-dark border"><?= htmlspecialchars($u->getStatutValidation()) ?></span></td>
                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($u->getRole()) ?></span></td>
                                    <td class="text-end">
                                        <form method="post" action="../src/traitement/validationUtilisateur.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $u->getIdUtilisateur() ?>">

                                            <input type="hidden" name="role" value="<?= $u->getRole() ?>">
                                            <button name="action" value="valider" class="btn btn-sm btn-success">Valider</button>

                                        </form>
                                        <form method="post" action="consultationUtilisateur.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $u->getIdUtilisateur() ?>">

                                            <button name="action" value="modifier" class="btn btn-sm btn-outline-primary">Consulter le profil</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<footer>
    <div class="container d-flex flex-wrap justify-content-between">
        <b class="foot-brand">LPRS</b>
        <div>
            <a href="#">Aide</a>
            <a href="#">Règles de la communauté</a>
            <a href="#">Mentions légales</a>
            <a href="#">Confidentialité</a>
        </div>
    </div>
    <div class="container mt-2">© 2026 LPRS. Tous droits réservés.</div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
