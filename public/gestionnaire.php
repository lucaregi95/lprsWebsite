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

    $afficherBannis = ($_GET['bannis'] ?? '') === '1';

    if ($afficherBannis) {
        $userGestionnaire=$rep->getAllUtilisateurWithRolesGestionnaire();
    }else{
        $userGestionnaire=$rep->getAllUtilisateurWithRolesGestionnaireNonBannis();
    }





function couleurBackground($statut)
{
    switch ($statut) {
        case "actif":
            return "bg-success text-light";

        case "en attente":
            return "bg-warning text-light";
        case "banni":
            return "bg-danger text-light";
        default:
            return "";
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__."/../src/traitement/newGestionnaire.php";
    require_once __DIR__."/../src/repository/gestionnaireRepository.php";

    if(isset($gestionnaire)){

        $rep = new gestionnaireRepository();
        $rep->ajoutGestionnaire($gestionnaire);
        header("location:gestionnaire.php");
    }
}}
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
    <div class="container">
        <div class="eyebrow">LPRS · Accueil</div>
        <?php if(isset($_SESSION["id_utilisateur"])){?>
            <h1>Bonjour <?=$_SESSION["prenom"]?>, bienvenue sur ton espace Administration.</h1>
        <?php }else{ ?>
            <h1>Créer votre compte ou connectez vous pour accéder a votre espace LPRS</h1>
        <?php }?>

        <p>Ici, vous trouverez les différents gestionnaires de la plateforme et pourrez les gérer</p>
    </div>
</header>



<div class="row justify-content-center my-4">
    <div class="col-lg-8 col-xl-7">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Liste des gestionnaires</h5>

                </div>


                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Ajouter un gestionnaire
                </button>

            </div>
            <div class="card-header bg-white border-0 pt-1 px-4 d-flex justify-content-between align-items-center">


                <span class="badge bg-primary text-light rounded-pill"><?= count($userGestionnaire)." gestionnaire(s)" ?></span>
                <form method="get" class="mb-0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                               id="filtreBannis" name="bannis" value="1"
                            <?= $afficherBannis ? 'checked' : '' ?>
                               onchange="this.form.submit()">
                        <label class="form-check-label small" for="filtreBannis">Afficher les bannis</label>
                    </div>
                </form>
            </div>


            <div class="card-body px-4">
                <?php if (empty($userGestionnaire)) { ?>
                    <p class="text-muted text-center my-4">Aucun gestionnaire.</p>
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
                            <?php foreach ($userGestionnaire as $u) { ?>
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

                                    <td><span class="badge <?php echo couleurBackground(htmlspecialchars($u->getStatutValidation()))?> border"><?= htmlspecialchars($u->getStatutValidation()) ?></span></td>
                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($u->getRole()) ?></span></td>
                                    <td class="text-end">
                                        <?php if($u->getStatutValidation() != "banni"){?>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $u->getIdUtilisateur() ?>">

                                            <input type="hidden" name="role" value="<?= $u->getRole() ?>">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#banModal"
                                                    data-id="<?= (int) $u->getIdUtilisateur() ?>"
                                                    data-role="<?= htmlspecialchars($u->getRole()) ?>"
                                                    data-nom="<?= htmlspecialchars($u->getPrenom() . ' ' . $u->getNom()) ?>">
                                                Bannir
                                            </button>


                                        </form>
                                        <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form method="post" action="utilisateur/bannirUtilisateur.php">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="banModalLabel">
                                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Avertissement
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p class="mb-1">Voulez-vous vraiment bannir <strong id="banNom"></strong> ?</p>
                                                            <p class="small text-muted mb-0">Cette action empêchera l'utilisateur d'accéder à la plateforme.</p>

                                                            <input type="hidden" name="id_utilisateur" id="banId">
                                                            <input type="hidden" name="role" id="banRole">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" name="action" value="bannir" class="btn btn-danger">Oui, bannir</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
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
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="eyebrow">Ajouter un gestionnaire</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="gestionnaire.php" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-event" name="nom" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="prenom">Prénom</label>
                        <textarea class="form-event" id="prenom" name="prenom" required autocomplete="off"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adresse e-mail</label>
                        <input type="text" class="form-event" name="email" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" class="form-event" name="mdp" required autocomplete="new-password">
                    </div>
                    <input type="hidden" name="date_inscription" id="date_inscription" value="<?=date("Y-m-d")?>"/>
                    <input type="hidden" name="statut_validation" id="statut_validation" value="actif"/>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('banModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;           // le bouton « Bannir » cliqué
        document.getElementById('banNom').textContent = btn.dataset.nom;
        document.getElementById('banId').value        = btn.dataset.id;
        document.getElementById('banRole').value      = btn.dataset.role;
    });
</script>
</body>
</html>