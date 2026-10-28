<?php
session_start();

require_once "../bdd/bdd.php";
require_once "../src/model/Utilisateur.php";
require_once "../src/model/Etudiant.php";
require_once "../src/model/Alumni.php";
require_once "../src/repository/UtilisateurRepository.php";
require_once "../src/repository/EtudiantRepository.php";
require_once "../src/repository/AlumniRepository.php";
require_once "../src/repository/PromotionRepository.php";
require_once "../src/model/Promotion.php";
require_once "../src/repository/FormationRepository.php";
require_once "../src/model/Formation.php";


if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$utilisateur = (new UtilisateurRepository())->getUtilisateur($id_utilisateur);
$infos = null;
$nomFormation = '';
$nomPromotion = '';
$promotionActuelle = null;

switch ($_SESSION['role']) {
    case 'etudiant':
        $infos = (new EtudiantRepository())->getEtudiant($id_utilisateur);

        $formationActuelle = $infos->getRefFormation();
        $promotionActuelle = $infos->getRefPromotion();



        if ($formationActuelle !== null) {
            $nomFormation = (new FormationRepository())->getFormation($formationActuelle)->getNomFormation();
        }
        if ($promotionActuelle !== null) {
            $nomPromotion = (new PromotionRepository())->getPromotion($promotionActuelle)->getAnnee();
        }
        break;

    case 'alumni':
        $infos = (new AlumniRepository())->getAlumni($id_utilisateur);
        break;

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        Campus - Profil
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>

</head>
<main>

<div class="profil-layout">

    <aside class="profil-sidebar">
        <div class="profil-logo"><a class="brand" href="accueil.php">
                <img class="logo-profil" src="img/logo.png">
            </a>
        </div>
        <a href="accueil.php">
            Accueil
        </a>
        <a href="evenement.php">
            Évènement
        </a>
        <a href="forum.php">
            Forum
        </a>
        <a href="offre.php">
            Offre
        </a>
    </aside>

    <div class="profil-main">

        <div class="profil-top">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle"></i>
                <div>
                    <?= htmlspecialchars($infos->getPrenom() . ' ' . $infos->getNom()) ?>
                </div>
            </div>
            <a class="nav-link" href="deconnexion.php">
                Déconnexion
            </a>
        </div>

        <div class="profil-box">
            <form method="POST" action="../src/traitement/modifierProfil.php">
                <div class="col-lg-9">
                    <div class="box_profil mb-4">
                        <h6>
                            Informations personnelles
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Prénom
                                </label>
                                <input class="form-control form-control-sm" type="text" name='prenom'value="<?= htmlspecialchars($infos->getPrenom(), ENT_QUOTES); ?>"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Nom
                                </label>
                                <input class="form-control form-control-sm" type="text"  name='nom' value="<?= htmlspecialchars($infos->getNom(), ENT_QUOTES); ?>"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Adresse e-mail
                                </label>
                                <input class="form-control form-control-sm" type="email" name="email" value="<?= htmlspecialchars($infos->getEmail(), ENT_QUOTES); ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    role
                                </label>
                                <input class="form-control form-control-sm" type="role" name="role" value="<?= $_SESSION['role'] ?>"   readonly />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Date d'inscription
                                </label>
                                <input class="form-control form-control-sm" type="text" name="date_inscription" value="<?= $infos->getDateInscription()  ?>"   readonly />
                            </div>
                        </div>
                        <h6 class="mt-4">
                            Mon parcours (étudiant)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small-t" for="classe">Formation</label>
                                <input class="form-control form-control-sm" type="text" id="classe"
                                       value="<?= htmlspecialchars((string) $nomFormation, ENT_QUOTES) ?>" readonly/>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small-t" for="promotion">Promotion</label>
                                <input class="form-control form-control-sm" type="text" id="promotion"
                                       value="<?= htmlspecialchars((string) $nomPromotion, ENT_QUOTES) ?>" readonly/>
                            </div>

                            <div class="col-md-6">
                            </div>
                            <div class="col-12">
                                <label class="form-label small-t">
                                    CV
                                </label>
                                <input class="form-control form-control-sm" type="file"/>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id_utilisateur" value="<?= $_SESSION['id_utilisateur'] ?>"/>
                    <input type="hidden" name="role" value="<?= $_SESSION['role'] ?>'"/>
            </form>
        </div>
        <div class="profil-events">
            <?php if (empty($mesEvenements)): ?>
                <div class="ev-card">Tu n'es inscrit à aucun évènement.</div>
            <?php endif; ?>
            <?php foreach ($mesEvenements as $evenement): ?>
                <div class="ev-card">
                    <b><?= htmlspecialchars($evenement->getTitre()) ?></b><br>
                    <small class="muted">
                        <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evenement->getLieu()) ?>
                    </small>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
