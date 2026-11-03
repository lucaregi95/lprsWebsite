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
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        .meta { color: #666; font-size: 0.85em; margin-bottom: 8px; }
        .role { background: #3b82f6; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 0.8em; }
        textarea, input[type=text] { width: 100%; padding: 8px; box-sizing: border-box; margin-bottom: 8px; }
        button { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-send { background: #22c55e; color: #fff; }
        .btn-report { background: #ef4444; color: #fff; font-size: 0.8em; }
        details { margin-top: 8px; }
    </style>
</head>
<body>
<div class="container">

    <!-- Sujet -->
    <div class="card">
        <h1><?= htmlspecialchars($sujet['titre']) ?></h1>
        <div class="meta">
            Par <strong><?= htmlspecialchars($sujet['nom']) ?></strong>
            <span class="role"><?= htmlspecialchars($sujet['role']) ?></span>
        </div>
        <p><?= nl2br(htmlspecialchars($sujet['contenu'])) ?></p>
    </div>

    <!-- Réponses -->
    <h2>Réponses (<?= count($reponses) ?>)</h2>
    <?php if (empty($reponses)): ?>
        <div class="card">Aucune réponse pour le moment.</div>
    <?php endif; ?>

    <?php foreach ($reponses as $reponse): ?>
        <div class="card">
            <div class="meta">
                <strong><?= htmlspecialchars($reponse['nom']) ?></strong>
                · <?= htmlspecialchars($reponse['datetime_reponse']) ?>
            </div>
            <p><?= nl2br(htmlspecialchars($reponse['contenu'])) ?></p>

            <!-- Signalement -->
            <details>
                <summary>Signaler</summary>
                <form method="post">
                    <input type="hidden" name="ref_signale" value="<?= (int)$reponse['ref_utilisateur'] ?>">
                    <input type="text" name="titre" placeholder="Motif" required>
                    <textarea name="contenu" rows="2" placeholder="Détails" required></textarea>
                    <button type="submit" class="btn-report">Envoyer le signalement</button>
                </form>
            </details>
        </div>
    <?php endforeach; ?>

    <!-- Formulaire de réponse -->
    <div class="card">
        <h3>Répondre</h3>
        <form method="post">
            <textarea name="contenu" rows="4" placeholder="Votre réponse..." required></textarea>
            <button type="submit" name="submit_btn" class="btn-send">Envoyer</button>
        </form>
    </div>

</div>
</body>
</html>
