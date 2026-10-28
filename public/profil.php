<?php
session_start();
//$mesEvenements = (new EvenementRepository())->getEvenementsByUtilisateur($id_utilisateur);
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
                    <div class="fs-5 lh-1">
                        Nassim Kharfouche
                    </div>
                    <small class="muted">
                        Étudiant · Promotion 2027
                    </small>
                </div>
            </div>
            <a class="nav-link" href="deconnexion.php">
                Déconnexion
            </a>
        </div>

        <div class="profil-box">
            form method="post">
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
                                <input class="form-control form-control-sm" type="text" value="<?= $utilisateur['prenom'] ?>"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Nom
                                </label>
                                <input class="form-control form-control-sm" type="text" value=<?= $utilisateur['nom'] ?>/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Adresse e-mail
                                </label>
                                <input class="form-control form-control-sm" type="email" value=<?= $utilisateur['email'] ?>  />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    role
                                </label>
                                <input class="form-control form-control-sm" type="role"  value="<?= $utilisateur['role'] ?> " readonly />
                            </div>

                            <div class="col-md-6">

                                <div class="mb-3 mdp-bloc">
                                    <label class="form-label small-t" for="mdp">Mot de passe</label>
                                    <input type="checkbox" id="voir-mdp" class="d-none"/>
                                    <div class="input-group input-group-sm">
                                        <input class="form-control form-control-sm champ-mdp" type="text" id="mdp" autocomplete="off" value="jsp"/>
                                        <label for="voir-mdp" class="btn btn-outline-secondary">
                                            <i class="bi bi-eye"></i>
                                            <i class="bi bi-eye-slash"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Date d'inscription
                                </label>
                                <input class="form-control form-control-sm" type="text" value="jj/mm/aaaa"/>
                            </div>
                        </div>
                        <h6 class="mt-4">
                            Mon parcours (étudiant)
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small-t">
                                    Formation
                                </label>
                                <select class="form-control" id="classe" name="ref_classe" required>
                                    <option value="">Sélectionne ta classe...</option>

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
                        <div class="text-end mt-3">
                            <button class="btn btn-primary">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
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
