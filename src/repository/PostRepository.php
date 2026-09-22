<?php

class PostRepository{

    private $connexionBdd;
    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getPost($id_post){
        $sql = "SELECT * FROM post WHERE id_post = : id_post";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_post', $id_post);
        $req->execute();
        $result = $req->fetch();
        $post = new Post($result["id_post"],$result["contenu"],$result["datetime"],$result["ref_utilisateur"]);
        return $post;

    }

    public function getAllPosts(){
        $sql = "SELECT * FROM post";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabPost = array();
        foreach($result as $post){
            $tabPost = new Post($result["id_post"],$result["contenu"],$result["datetime"],$result["ref_utilisateur"]);
        }
        return $tabPost;
    }

    public function ajouterPost(Post $id_post){
        $sql = "INSERT INTO post(id_post,contenu,datetime,ref_utilisateur) VALUES(:id_post,:contenu,:datetime,:ref_utilisateur)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_post',$id_post->getIdPost());
        $req->bindValue(':contenu',$id_post->getContenu());
        $req->bindValue(':datetime',$id_post->getDateTime());
        $req->bindValue(':ref_utilisateur',$id_post->getRefUtilisateur());
        $req->execute();

    }

    public function supprimerPost($id_post){
        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_post',$id_post);
        $req->execute();
    }

    public function modifierPost(Post $post){
        $sql = "UPDATE post SET contenu=:contenu, datetime=:datetime, ref_utilisateur=:ref_utilisateur WHERE id_post=:id_post";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':contenu',$post->getContenu());
        $req->bindValue(':datetime',$post->getDateTime());

        $req->bindValue(':id_post',$post->getIdPost());
        $req->execute();

    }



}