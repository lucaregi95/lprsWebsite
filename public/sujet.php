<?php
session_start();
require_once '../bdd/bdd.php';
require_once "../src/model/reponse.php";
require_once "../src/repository/reponseRepository.php";
require_once "../src/model/post.php";
require_once "../src/repository/postRepository.php";
require_once "../src/model/VueUtilisateurRole.php";
require_once "../src/repository/VueUtilisateurRoleRepository.php";
$bdd = new Bdd();
$connexionBdd = $bdd->getConnexionBdd();

if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){
    header("location:connexion.php?page=f");
    exit();
}

$id_post = $_GET['id'];
$ref_utilisateur = $_SESSION['id_utilisateur'];

// Récupère le sujet avec les infos de son auteur (pseudo et rôle)
$connexion = $connexionBdd->prepare("SELECT v.*, p.* FROM post AS p INNER JOIN v_utilisateurwithrole AS v ON p.ref_utilisateur = v.id_utilisateur WHERE p.id_post = :id");
$connexion->execute(["id" => $id_post]);
$sujet = $connexion->fetch(PDO::FETCH_ASSOC);

// Traitement de la soumission d'une réponse
if(isset($_POST['submit_btn'])){
    $contenu = $_POST['contenu'];
    $date    = date('Y-m-d');
    $sql = "INSERT INTO reponse (contenu, datetime_reponse, ref_utilisateur, ref_post)  VALUES (:contenu, :datetime_reponse, :ref_utilisateur, :ref_post)";
    $query = $connexionBdd->prepare($sql);
    $query->execute([
        "contenu"      => $contenu,
        "datetime_reponse" => $date,
        "ref_utilisateur"  => $ref_utilisateur,
        "ref_post"    => $id_post,
    ]);
    header("Location: sujet.php?id=$id_post");
    exit();
}

// Récupère toutes les réponses du sujet triées du plus ancien au plus récent
$stmt2 = $connexionBdd->prepare(" SELECT r.*, u.nom FROM reponse AS r INNER JOIN utilisateur  AS  u ON r.ref_utilisateur = u.id_utilisateur WHERE r.ref_post = :id ORDER BY r.datetime_reponse ASC");
$stmt2->execute(["id" => $id_post]);
$reponses = $stmt2->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['ref_signale']) && isset($_POST['contenu'])) {
    $sqlSignalement = "INSERT INTO signalement (ref_signalant, ref_signale, contenu, date, titre) VALUES (:ref_signalant, :ref_signale, :contenu, CURDATE(), :titre)";
    $querySignalement = $connexion->prepare($sqlSignalement);
    $querySignalement->execute([
        'ref_signalant' => $_SESSION['id'],
        'ref_signale' => $_POST['ref_signale'],
        'contenu' => $_POST['contenu'],
        'titre' => $_POST['titre']
    ]);


}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($sujet['titre'] ?? 'Sujet') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 800px;">

    <!-- Bouton retour -->
    <a href="forum.php" class="btn btn-outline-primary mb-3">&larr; Retour au forum</a>

    <!-- Sujet -->
    <div class="card border-primary shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0"><?= htmlspecialchars($sujet['titre']) ?></h1>
        </div>
        <div class="card-body">
            <div class="text-muted small mb-3">
                Par <strong><?= htmlspecialchars($sujet['nom']) ?></strong>
                <span class="badge bg-primary"><?= htmlspecialchars($sujet['role']) ?></span>
            </div>
            <p class="mb-0"><?= nl2br(htmlspecialchars($sujet['contenu'])) ?></p>
        </div>
    </div>

    <!-- Réponses -->
    <h2 class="h5 mb-3">Réponses <span class="badge bg-secondary"><?= count($reponses) ?></span></h2>
    <?php if (empty($reponses)): ?>
        <div class="alert alert-info">Aucune réponse pour le moment.</div>
    <?php endif; ?>

    <?php foreach ($reponses as $i => $reponse): ?>
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="text-muted small">
                        <strong class="text-primary"><?= htmlspecialchars($reponse['nom']) ?></strong>
                        · <?= htmlspecialchars($reponse['datetime_reponse']) ?>
                    </div>
                    <!-- Bouton signaler -->
                    <button class="btn btn-outline-danger btn-sm" type="button"
                            data-bs-toggle="collapse" data-bs-target="#signal<?= $i ?>">
                        Signaler
                    </button>
                </div>
                <p class="mb-0"><?= nl2br(htmlspecialchars($reponse['contenu'])) ?></p>

                <!-- Formulaire de signalement -->
                <div class="collapse mt-3" id="signal<?= $i ?>">
                    <form method="post" class="border border-danger rounded p-3 bg-danger-subtle">
                        <input type="hidden" name="ref_signale" value="<?= (int)$reponse['ref_utilisateur'] ?>">
                        <input type="text" name="titre" class="form-control form-control-sm mb-2" placeholder="Motif" required>
                        <textarea name="contenu" rows="2" class="form-control form-control-sm mb-2" placeholder="Détails" required></textarea>
                        <button type="submit" class="btn btn-danger btn-sm">Envoyer le signalement</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Formulaire de réponse -->
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white">Répondre</div>
        <div class="card-body">
            <form method="post">
                <textarea name="contenu" rows="4" class="form-control mb-2" placeholder="Votre réponse..." required></textarea>
                <button type="submit" name="submit_btn" class="btn btn-success">Envoyer</button>
            </form>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>