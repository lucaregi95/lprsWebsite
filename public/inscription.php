<?php
require_once "../bdd/bdd.php";
require_once "../src/model/Promotion.php";
require_once "../src/repository/PromotionRepository.php";
$repPromotion = new PromotionRepository();
$promotions = $repPromotion -> getPromotions();

require_once "../src/model/Entreprise.php";
require_once "../src/repository/EntrepriseRepository.php";
$repEntreprise = new EntrepriseRepository();
$entreprises = $repEntreprise -> getEntreprises();

require_once "../src/model/Formation.php";
require_once "../src/repository/FormationRepository.php";
$repFormation = new FormationRepository();
$formations = $repFormation -> getFormations();







?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width,initial-scale=1" name="viewport"/>
    <title>
        LPRS - Inscription
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="style/style.css" rel="stylesheet"/>

</head>
<body class="body_connexion">
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

        </div>
    </div>
</nav>
<main class="container mt-5">
    <div class="auth-wrapper">
        <div class="auth">
            <div class="p-4 p-lg-5">
                <div class="auth-form">

                    <h4 class="fw-bold text-center">Inscription</h4>
                    <p class="muted small-t text-center">Renseigne tes informations.</p>

                            <form method="POST" action="inscription2.php">
                        <div class="mb-3">
                            <label class="form-label small-t">
                                Prénom
                            </label>
                            <input class="form-control form-control-sm" type="text" value="" name="prenom" id="prenom"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small-t">
                                Nom
                            </label>
                            <input class="form-control form-control-sm" type="text" value="" name="nom" id="nom"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small-t">
                                Adresse e-mail
                            </label>
                            <input class="form-control form-control-sm" type="email" value="" name="email" id="email"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small-t">
                                Mot de passe
                            </label>
                            <input class="form-control form-control-sm" type="password" value="" name="mdp" id="mdp"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small-t">
                                Je suis
                            </label>
                            <select class="form-select form-select-sm" id="type" name="type">
                                <option value="etudiant">
                                    Étudiant
                                </option>
                                <option value="alumni">
                                    Alumni
                                </option>
                                <option value="partenaire">
                                    Partenaire
                                </option>
                                <option value="professeur">
                                    Professeur
                                </option>
                            </select>
                        </div>
                        <div class="type-grp row g-3 mb-3" data-type="etudiant" hidden="">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Formation
                                </label>
                                <select class="form-select form-select-sm">
                                    <option>
                                        BUT Informatique
                                    </option>
                                    <option>
                                        Master MIAGE
                                    </option>
                                    <option>
                                        Licence Droit
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Promotion
                                </label>
                                <select class="form-select form-select-sm">
                                    <option>
                                        2027
                                    </option>
                                    <option>
                                        2026
                                    </option>
                                    <option>
                                        2025
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small-t">
                                    CV
                                </label>
                                <input class="form-control form-control-sm" type="file"/>
                            </div>
                        </div>
                        <div class="type-grp row g-3 mb-3" data-type="alumni" hidden="">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Poste occupé
                                </label>
                                <input class="form-control form-control-sm" type="text" value="" name="poste_occupe" id="poste_occupe"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Promotion
                                </label>
                                <select class="form-select form-select-sm" id="ref_promotion" name="ref_promotion">
                                    <option value="1">
                                        TEST
                                    </option>
                                    <option>
                                        2026
                                    </option>
                                    <option>
                                        2025
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Entreprise
                                </label>
                                <select class="form-select form-select-sm" name="ref_entreprise" id="ref_entreprise">
                                    <option value="1">
                                        TEST
                                    </option>
                                    <option>
                                        Studio Nord
                                    </option>
                                    <option>
                                        DataCorp
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small-t">
                                    CV
                                </label>
                                <input class="form-control form-control-sm" type="file" name="cv" id="cv"/>
                            </div>
                        </div>
                        <div class="type-grp row g-3 mb-3" data-type="partenaire" hidden="">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Poste occupé
                                </label>
                                <input class="form-control form-control-sm" type="text" value=""/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Entreprise
                                </label>
                                <select class="form-select form-select-sm">
                                    <option>
                                        Agence Lumière
                                    </option>
                                    <option>
                                        Studio Nord
                                    </option>
                                    <option>
                                        DataCorp
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small-t">
                                    Motif d'inscription
                                </label>
                                <input class="form-control form-control-sm" type="text" value=""/>
                            </div>
                        </div>
                        <div class="type-grp row g-3 mb-3" data-type="professeur" hidden="">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Spécialité
                                </label>
                                <input class="form-control form-control-sm" type="text" value=""/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Formation enseignée
                                </label>
                                <select class="form-control" id="classe" name="ref_classe" required>


                                    <optgroup label="Lycée Professionnel">
                                        <option value="1">Troisième Prépa Pro</option>
                                        <option value="2">Bac Pro TRPM</option>
                                        <option value="3">Bac Pro MSPC</option>
                                        <option value="4">Bac Pro CIEL</option>
                                        <option value="5">Formation SST</option>
                                    </optgroup>

                                    <optgroup label="Lycée Technologique">
                                        <option value="6">Bac STI2D</option>
                                    </optgroup>

                                    <optgroup label="Enseignement supérieur et UFA">
                                        <option value="7">BTS CPRP</option>
                                        <option value="8">BTS SIO – Option SISR</option>
                                        <option value="9">BTS SIO – Option SLAM</option>
                                        <option value="10">BTS MS</option>
                                        <option value="11">CQPM</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                                <input type="hidden" name="date_inscription" id="date_inscription" value="2026-10-10"/>
                                <input type="hidden" name="statut_validation" id="statut_validation" value="en attente"/>
                        <p class="muted small-t">
                            Ton compte sera vérifié (statut : en attente) avant validation.
                        </p>
                        <div class="form-check small-t mb-3">
                            <input class="form-check-input" type="checkbox"/>
                            J’accepte les conditions d’utilisation
                        </div>
                        <button class="btn btn-primary w-100" type="submit">
                            Créer mon compte
                        </button>
                    </form>

                    <p class="small-t text-center mt-3 mb-0">
                        Déjà inscrit ?
                    </p>
                        <a href="connexion.php">Connexion</a>
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
<script>
    function m(){document.querySelectorAll(".type-grp").forEach(g=>g.hidden=g.dataset.type!==document.getElementById("type").value)}document.getElementById("type").addEventListener("change",m);m();
</script>
</body>
</html>
