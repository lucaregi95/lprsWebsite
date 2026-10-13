<?php

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
        $sql = "INSERT INTO post(id_post,contenu,date_sujet,titre,ref_utilisateur,categorie_sujet) VALUES(:id_post,:contenu,:date_sujet,:titre,:ref_utilisateur,:categorie_sujet)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post',$id_post->getIdPost());
        $req->bindValue(':contenu',$id_post->getContenu());
        $req->bindValue(':date_sujet',$id_post->getDateSujet());
        $req->execute();

    }

    public function supprimerPost($id_post){
        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_post',$id_post);
        $req->execute();
    }

    public function modifierPost(Post $post){
        $sql = "UPDATE post SET contenu=:contenu, date=:date_sujet, titre=:titre,categorie_sujet=:categorie_sujet, WHERE id_post=:id_post";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':contenu',$post->getContenu());
        $req->bindValue(':dateusujet',$post->getDateSujet());
        $req->bindValue(':id_post',$post->getIdPost());
        $req->execute();

    }



}