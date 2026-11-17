<?php
$connexionBdd = $bdd->getConnexionBdd();

// Seulement les posts de l'utilisateur connecté
$sql = "SELECT post.id_post, post.titre, post.date_post, post.categorie_post,
               (SELECT COUNT(*) FROM reponse WHERE reponse.ref_post = post.id_post) AS nb_reponses
        FROM post
        WHERE post.ref_utilisateur = :id_utilisateur
        ORDER BY post.date_post DESC";

$req = $connexionBdd->prepare($sql);
$req->execute(['id_utilisateur' => $_SESSION['id_utilisateur']]);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);




?>