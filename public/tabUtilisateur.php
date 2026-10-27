<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . "/../src/traitement/newAlumni.php";
require_once __DIR__ . "/../src/repository/AlumniRepository.php";
require_once __DIR__ . "/../src/model/Alumni.php";

require_once __DIR__ . "/../src/traitement/newEtudiant.php";
require_once __DIR__ . "/../src/repository/EtudiantRepository.php";
require_once __DIR__ . "/../src/model/Etudiant.php";

require_once __DIR__ . "/../src/traitement/newPartenaire.php";
require_once __DIR__ . "/../src/repository/PartenaireRepository.php";
require_once __DIR__ . "/../src/model/Partenaire.php";

require_once __DIR__ . "/../src/traitement/newProfesseur.php";
require_once __DIR__ . "/../src/repository/ProfesseurRepository.php";
require_once __DIR__ . "/../src/model/Professeur.php";

//require_once "../src/traitement/newUtilisateur.php";
//require_once "../src/repository/UtilisateurRepository.php";
//require_once "../src/model/Utilisateur.php";

$alumniRepository = new AlumniRepository();
$tabAlumni = $alumniRepository->getAllAlumnis();

$etudiantRepository = new EtudiantRepository();
$tabEtudiant = $etudiantRepository->getAllEtudiants();

$partenaireRepository = new PartenaireRepository();
$tabPartenaire = $partenaireRepository->getAllPartenaires();

$professeurRepository = new ProfesseurRepository();
$tabProfesseur = $professeurRepository->getAllProfesseurs();

//$utilisateurRepository = new UtilisateurRepository();
//$tabUtilisateur = $utilisateurRepository->getAllUtilisateurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LPRS - Liste Utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>

<div class="page-header">
    <div class="container-fluid px-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-people me-2"></i>Gestion des utilisateurs</h1>
                <p>Administration · LPRS</p>
            </div>
            <div class="d-flex gap-2">
                <a href="../AccesAdmin/accesAdmin.php" class="btn-back">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
                <form method="post" action="inscription.php" class="d-inline">
                    <button type="submit" class="btn-add">
                        <i class="bi bi-plus-lg me-1"></i> Ajouter un utilisateur
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4 pb-5">
    

    <?php if (!empty($tabUtilisateur)){ ?>

        <p class="text-muted mb-3" style="font-size:0.875rem;">
            <i class="bi bi-people me-1"></i>
            <strong><?= count($tabUtilisateur) ?></strong> utilisateur(s) répertorié(s)
        </p>

        <div class="card card-table">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rue</th>
                        <th>CP</th>
                        <th>Ville</th>
                        <th>Naissance</th>
                        <th>Rôle</th>
                        <th>État</th>
                        <th>Création</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($tabUtilisateur as $utilisateur) { ?>
                        <tr>
                            <td><span class="utilisateur-id"><?= $utilisateur->getID() ?></span></td>
                            <td><span class="utilisateur-name"><?= $utilisateur->getNom() ?></span></td>
                            <td><?= $utilisateur->getPrenom() ?></td>
                            <td><?= $utilisateur->getEmail() ?></td>
                            <td><?= $utilisateur->getTelephone() ?: '—' ?></td>
                            <td><?= $utilisateur->getRue() ?: '—' ?></td>
                            <td><?= $utilisateur->getCp() ?: '—' ?></td>
                            <td><?= $utilisateur->getVille() ?: '—' ?></td>
                            <td><?= $utilisateur->getDateNaissance() ?: '—' ?></td>
                            <td>
                                <?php
                                $role = $utilisateur->getRole();
                                if ($role == 'admin') {
                                    $classBadge = 'badge-role badge-role-admin';
                                } else if ($role == 'accueil') {
                                    $classBadge = 'badge-role badge-role-accueil';
                                } else {
                                    $classBadge = 'badge-role badge-role-user';
                                }
                                ?>
                                <span class="<?= $classBadge ?>"><?= $role ?></span>
                            </td>
                            <td>
                                <?php if ($utilisateur->getEtat() == 1){ ?>
                                    <span class="badge-etat-actif">Actif</span>
                                <?php }else{ ?>
                                    <span class="badge-etat-inactif">Inactif</span>
                                <?php } ?>
                            </td>
                            <td><?= $utilisateur->getDateCreation() ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form method="post" action="modificationUtilisateur.php">
                                        <button type="submit" class="btn-modify">
                                            <i class="bi bi-pencil me-1"></i>Modifier
                                        </button>
                                        <input type="hidden" name="id" value="<?= $utilisateur->getIdActeur() ?>">
                                    </form>
                                    <form method="post" action="suppressionUtilisateur.php">
                                        <button type="submit" class="btn-delete">
                                            <i class="bi bi-trash me-1"></i>Supprimer
                                        </button>
                                        <input type="hidden" name="id" value="<?= $utilisateur->getIdActeur() ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php }else{ ?>

        <div class="empty-state">
            <i class="bi bi-people"></i>
            <h4>Aucun utilisateur pour le moment</h4>
            <p>Commencez par ajouter votre premier utilisateur.</p>
            <form method="post" action="inscription.php" class="d-inline">
                <button type="submit" class="btn-add mt-2">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un utilisateur
                </button>
            </form>
        </div>

    <?php } ?>

</div>
</body>
</html>