<?php
require_once __DIR__.'/../../bdd/bdd.php';
class PostRepository{

    private $connexionBdd;
    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getPost($id_post){
        $sql = "SELECT * FROM post WHERE id_post = : id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post', $id_post);
        $req->execute();
        $result = $req->fetch();
        $post = new Post($result["id_post"],$result["contenu"],$result["date_sujet"],$result["titre"],$result["ref_utilisateur"],$result["categorie_sujet"]);
        return $post;

    }

    public function getAllPosts(){
        $sql = "SELECT * FROM post";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabPost = array();
        foreach($result as $post){
            $post = new Post($result["id_post"],$result["contenu"],$result["date_sujet"],$result["titre"],$result["ref_utilisateur"],$result["categorie_sujet"]);
            $tabPost[] = $post;
        }
        return $tabPost;
    }

    public function ajouterPost(Post $id_post){
        $sql = "INSERT INTO post(id_post,contenu,date_post,titre,ref_utilisateur,categorie_post) VALUES(:id_post,:contenu,:date_post,:titre,:categorie_post,:ref_utilisateur)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post',$id_post->getIdPost());
        $req->bindValue(':contenu',$id_post->getContenu());
        $req->bindValue(':date_Post',$id_post->getDatePost());
        $req->bindValue(':titre',$id_post->getTitre());
        $req->bindValue(':categorie_post',$id_post->getCategoriePost());
        $req->bindValue(':ref_utilisateur',$id_post->getRefUtilisateur());
        $req->execute();
    }

    public function supprimerPost($id_post){
        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post',$id_post);
        $req->execute();
    }

    public function modifierPost(Post $post){
        $sql = "UPDATE post SET contenu=:contenu, date=:date_post, titre=:titre,categorie_post=:categorie_post, WHERE id_post=:id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':contenu',$post->getContenu());
        $req->bindValue(':datePost',$post->getDatePost());
        $req->bindValue(':id_post',$post->getIdPost());
        $req->execute();

    }



}