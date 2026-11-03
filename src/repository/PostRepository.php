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
        $result = $req->fetch();
        $post = new Post($result["id_post"],$result["contenu"],$result["date_sujet"],$result["titre"],$result["ref_utilisateur"],$result["categorie_post"]);
        return $post;

    }

    public function getAllPosts(){
        $req = $this->connexionBdd->prepare("SELECT * FROM post");
        $req->execute();
        $results = $req->fetchAll();
        $tabPost = array();
        foreach($results as $result){
            $tabPost[] = new Post($result["id_post"],$result["contenu"],$result["date_sujet"],$result["ref_utilisateur"],$result["categorie_post"],$result["titre"]);
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
        $sql = "UPDATE post SET contenu=:contenu, date_post=:date_post, titre=:titre,categorie_post=:categorie_post WHERE id_post=:id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':contenu', $post->getContenu());
        $req->bindValue(':titre', $post->getTitre());
        $req->bindValue(':categorie_post', $post->getCategoriePost());
        $req->bindValue(':id_post', $post->getIdPost());
        $req->execute();
    }



}