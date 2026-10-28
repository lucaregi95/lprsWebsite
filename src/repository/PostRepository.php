<?php
require_once __DIR__.'/../../bdd/bdd.php';
class PostRepository{

    private $connexionBdd;
    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getPost($id_post){
        $sql = "SELECT * FROM post WHERE id_post = :id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post', $id_post);
        $req->execute();
        $r = $req->fetch(PDO::FETCH_ASSOC);
        return new Post($r["id_post"], $r["contenu"], $r["date_post"], $r["titre"], $r["categorie_post"], $r["ref_utilisateur"]);
    }

    public function getAllPosts(){
        $req = $this->connexionBdd->prepare("SELECT * FROM post");
        $req->execute();
        $tabPost = [];
        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $tabPost[] = new Post($r["id_post"], $r["contenu"], $r["date_post"], $r["titre"], $r["categorie_post"], $r["ref_utilisateur"]);
        }
        return $tabPost;
    }

    public function ajouterPost(Post $post){
        $sql = "INSERT INTO post(contenu, date_post, titre, categorie_post, ref_utilisateur)
            VALUES(:contenu, :date_post, :titre, :categorie_post, :ref_utilisateur)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':contenu', $post->getContenu());
        $req->bindValue(':date_post', $post->getDatePost());
        $req->bindValue(':titre', $post->getTitre());
        $req->bindValue(':categorie_post', $post->getCategoriePost());
        $req->bindValue(':ref_utilisateur', $post->getRefUtilisateur());
        $req->execute();
    }

    public function modifierPost(Post $post){
        $sql = "UPDATE post SET contenu=:contenu, titre=:titre, categorie_post=:categorie_post WHERE id_post=:id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':contenu', $post->getContenu());
        $req->bindValue(':titre', $post->getTitre());
        $req->bindValue(':categorie_post', $post->getCategoriePost());
        $req->bindValue(':id_post', $post->getIdPost());
        $req->execute();
    }



}