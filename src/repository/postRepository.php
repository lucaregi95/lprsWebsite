<?php

class postRepository{

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
        $post = new Post($result["id_post"],$result["contenu"],$result["date"],$result["heure"]);
        return $post;

    }

    public function getAllPosts(){
        $sql = "SELECT * FROM post";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabPost = array();
        foreach($result as $post){
            $post = new Post($result["id_post"],$result["contenu"],$result["date"],$result["heure"]);
            $tabPost[] = $post;
        }
        return $tabPost;
    }

    public function ajouterPost(Post $id_post){
        $sql = "INSERT INTO post(id_post,contenu,date,heure) VALUES(:id_post,:contenu,:date,:heure)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_post',$id_post->getIdPost());
        $req->bindValue(':contenu',$id_post->getContenu());
        $req->bindValue(':date',$id_post->getDate());
        $req->bindValue(':heure',$id_post->getHeure());
        $req->execute();

    }

    public function supprimerPost($id_post){
        $sql = "DELETE FROM post WHERE id_post = :id_post";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_post',$id_post);
        $req->execute();
    }

    public function modifierPost(Post $post){
        $sql = "UPDATE post SET contenu=:contenu, date=:date, heure=:heure WHERE id_post=:id_post";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':contenu',$post->getContenu());
        $req->bindValue(':date',$post->getDate());
        $req->bindValue(':heure',$post->getHeure());
        $req->bindValue(':id_post',$post->getIdPost());
        $req->execute();

    }



}