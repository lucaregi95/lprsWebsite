<?php
session_start ();
require_once '../bdd/bdd.php';
require_once 'sujet.php';


if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:../connexion.php");
    exit();
}


if (isset($_POST['supprimer']) && isset($_POST['id_post'])) {
    $id_sujet = (int)$_POST['id_post'];

    $sqlDelRep = "DELETE FROM reponse WHERE ref_post = :id";
    $qDelRep = $connexion->prepare($sqlDelRep);
    $qDelRep->execute(['id' => $id_sujet]);

    // Puis supprime le sujet lui-même
    $sqlDel = "DELETE FROM post WHERE id_post = :id";
    $qDel = $connexion->prepare($sqlDel);
    $qDel->execute(['id' => $id_post]);


    header("location:forum_admin.php?supprime=1");
    exit();
}

// Récupère les filtres depuis l'URL (GET)
if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
} else {
    $recherche = '';
}
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
} else {
    $categorie = '';
}

$sql = "SELECT sujet.id_sujet, sujet.titre, sujet.date_sujet, sujet.categorie_sujet, (SELECT COUNT(*) FROM reponse WHERE reponse.ref_sujet = sujet.id_sujet) as nb_reponses FROM sujet INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit WHERE 1=1";

$params = [];
if ($recherche !== '') {
    $sql .= " AND (sujet.titre LIKE :recherche OR inscrit.pseudo LIKE :recherche)";
    $params['recherche'] = '%' . $recherche . '%';
}
if ($categorie !== '') {
    $sql .= " AND sujet.categorie_sujet = :categorie";
    $params['categorie'] = $categorie;
}
$sql .= " ORDER BY sujet.date_sujet DESC";

$req = $connexion->prepare($sql);
$req->execute($params);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);

// Récupère les catégories distinctes pour le filtre (PDO::FETCH_COLUMN = tableau simple)
$qCat = $connexion->prepare("SELECT DISTINCT categorie_sujet FROM sujet ORDER BY categorie_sujet");
$qCat->execute();
$categories = $qCat->fetchAll(PDO::FETCH_COLUMN);

$daltonisme_session = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
$dyslexie_session = isset($_SESSION['dyslexie']) ? $_SESSION['dyslexie'] : false;
$palettes = [
    'aucun' => ['danger' => '#dc3545', 'danger_rgb' => '220,53,69', 'danger_dark' => '#58151c', 'danger_bg_subtle' => '#f8d7da', 'danger_border_subtle' => '#f1aeb5', 'link' => '#0d6efd', 'link_rgb' => '13,110,253', 'tag_bg' => '#dc3545', 'switch_on' => '#dc3545'],
    'deuteranopie' => ['danger' => '#0055cc', 'danger_rgb' => '0,85,204', 'danger_dark' => '#002a66', 'danger_bg_subtle' => '#cce0ff', 'danger_border_subtle' => '#99c1ff', 'link' => '#e07b00', 'link_rgb' => '224,123,0', 'tag_bg' => '#0055cc', 'switch_on' => '#0055cc'],
    'tritanopie' => ['danger' => '#cc3300', 'danger_rgb' => '204,51,0', 'danger_dark' => '#661a00', 'danger_bg_subtle' => '#ffe5dd', 'danger_border_subtle' => '#ffbba8', 'link' => '#007a33', 'link_rgb' => '0,122,51', 'tag_bg' => '#cc3300', 'switch_on' => '#cc3300'],
    'protanopie' => ['danger' => '#6600cc', 'danger_rgb' => '102,0,204', 'danger_dark' => '#330066', 'danger_bg_subtle' => '#ead5ff', 'danger_border_subtle' => '#cc99ff', 'link' => '#007acc', 'link_rgb' => '0,122,204', 'tag_bg' => '#6600cc', 'switch_on' => '#6600cc'],
];
$p = isset($palettes[$daltonisme_session]) ? $palettes[$daltonisme_session] : $palettes['aucun'];


?>