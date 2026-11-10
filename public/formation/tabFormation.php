<?php
session_start();
if(!(isset($_SESSION['statut_validation'])) || ($_SESSION['statut_validation'] != 'admin' ) && $_SESSION['role'] != 'gestionnaire') {
    header("Location: ../accueil.php");
    exit;
}else{
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../src/traitement/newFormation.php';
require_once __DIR__ . '/../../src/repository/FormationRepository.php';

$formationRepository = new FormationRepository();

// Ajout
if (isset($formation)) {
    $formationRepository->ajouterFormation($formation);
    header('Location: tabformation.php');
    exit;
}

// Modification
if (isset($_POST['btn_modifier'])) {
    $formationModifiee = new Formation(
        $_POST['id_formation'],
        $_POST['nom_formation_modif']
    );
    $formationRepository->modifierFormation($formationModifiee);
    header('Location: tabformation.php');
    exit;
}

$formations = $formationRepository->getAllFormations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>LPRS - Formations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <!-- Chemin adapté : ce fichier est dans un sous-dossier -->
    <link href="../style/style.css" rel="stylesheet"/>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="brand" href="../accueil.php">
            <img class="logo" src="../img/logo.png" alt="LPRS">
        </a>
        <button class="navbar-toggler" data-bs-target="#m" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="m">
            <ul class="navbar-nav ms-4 me-auto">
                <li class="nav-item"><a class="nav-link" href="../accueil.php">Accueil</a></li>

                <?php if (isset($_SESSION['statut_validation']) && $_SESSION['statut_validation'] == 'admin') { ?>
                    <li class="nav-item"><a class="nav-link" href="../admin.php">Administration</a></li>
                    <li class="nav-item"><a class="nav-link" href="../gestionnaire.php">Gestionnaire</a></li>
                    <li class="nav-item"><a class="nav-link active" href="tabformation.php">Formations</a></li>
                <?php } ?>
            </ul>

            <?php if (isset($_SESSION["id_utilisateur"])) { ?>
                <div class="dropdown">
                    <a class="text-decoration-none text-dark d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <span class="avatar"><?= htmlspecialchars($_SESSION["prenom"][0] . $_SESSION["nom"][0]) ?></span>
                        <span class="small"><?= htmlspecialchars($_SESSION["prenom"] . " " . $_SESSION["nom"]) ?> <i class="bi bi-chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../profil.php">Profil</a></li>
                        <li><a class="dropdown-item" href="../deconnexion.php">Déconnexion</a></li>
                    </ul>
                </div>
            <?php } else { ?>
                <a class="nav-link" href="../inscription.php">Inscription/</a>
                <a class="nav-link" href="../connexion.php">Connexion</a>
            <?php } ?>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="eyebrow">LPRS · Formations</div>
        <h1>Gestion des formations</h1>
        <p>Ici, vous pouvez consulter, ajouter, modifier et supprimer les formations de la plateforme.</p>
    </div>
</header>

<div class="row justify-content-center my-4">
    <div class="col-lg-8 col-xl-7">

        <div class="card border-0 shadow rounded-4">

            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Liste des formations</h5>
                </div>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Ajouter une formation
                </button>
            </div>

            <div class="card-header bg-white border-0 pt-1 px-4 d-flex justify-content-between align-items-center">
                <span class="badge bg-primary text-light rounded-pill"><?= count($formations) ?> formation(s)</span>
            </div>

            <div class="card-body px-4">
                <?php if (empty($formations)) { ?>
                    <p class="text-muted text-center my-4">Aucune formation.</p>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-muted small">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($formations as $formation) { ?>
                                <tr>
                                    <td class="small text-muted">#<?= (int) $formation->getIdFormation() ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($formation->getNomFormation()) ?></td>
                                    <td class="text-end">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal"
                                                data-id="<?= (int) $formation->getIdFormation() ?>"
                                                data-nom="<?= htmlspecialchars($formation->getNomFormation()) ?>">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="<?= (int) $formation->getIdFormation() ?>"
                                                data-nom="<?= htmlspecialchars($formation->getNomFormation()) ?>">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
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

<!-- Modale d'ajout -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="eyebrow" id="addModalLabel">Ajouter une formation</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form method="post" action="tabformation.php" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="nom_formation">Nom de la formation</label>
                        <input type="text" class="form-control" name="nom_formation" id="nom_formation" required>
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
<!-- Modale de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="supprimerFormation.php">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Avertissement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-1">Voulez-vous vraiment supprimer la formation <strong id="deleteNom"></strong> ?</p>
                    <p class="small text-muted mb-0">Cette action est définitive.</p>
                    <input type="hidden" name="id_formation" id="deleteId">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modale de modification -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="eyebrow" id="editModalLabel">Modifier la formation</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form method="post" action="tabformation.php" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="editId">ID</label>
                        <input type="text" class="form-control" name="id_formation" id="editId" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="editNom">Nom de la formation</label>
                        <input type="text" class="form-control" name="nom_formation_modif" id="editNom" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" name="btn_modifier" value="1" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('deleteNom').textContent = btn.dataset.nom;
        document.getElementById('deleteId').value = btn.dataset.id;
    });
    const editModal = document.getElementById('editModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('editId').value  = btn.dataset.id;
        document.getElementById('editNom').value = btn.dataset.nom;
    });

    editModal.addEventListener('shown.bs.modal', function () {
        document.getElementById('editNom').focus();
    });
</script>
</body>
</html>
<?php } ?>