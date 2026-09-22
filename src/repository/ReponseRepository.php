<?php

class ReponseRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getReponse($id_reponse){
        $sql = "SELECT * FROM reponse WHERE id_reponse = :id_reponse ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_reponse', $id_reponse);
        $req->execute();
        $result = $req->fetch();
        $reponse = new Reponse($result['id_reponse'],$result['contenu'],$result['datetime_reponse'],$result['ref_utilisateur'],$result['ref_post']);
        return $reponse;

    }

    public function getAllReponses(){
        $sql = "SELECT * FROM reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabReponse = array();
        foreach($result as $row){
            $reponse = new Reponse($result['$id_reponse'],$result['contenu'],$result['datetime_reponse'],$result['ref_utilisateur'],$result['ref_post']);

            $tabReponse[] = $reponse;
        }
        return $tabReponse;
    }

    public function ajouterReponse(Reponse $id_reponse){
        $sql = "INSERT INTO reponse (contenu,datetime_reponse,ref_utilisateur,ref_post) VALUES (:contenu,:datetime_reponse,:ref_utilisateur,:ref_post)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse->getIdReponse());
        $req->bindValue(':contenu', $id_reponse->getContenu());
        $req->bindValue(':datetime_reponse', $id_reponse->getDatetimeReponse());
        $req->bindValue(':ref_utilisateur', $id_reponse->getrefUtilisateur());
        $req->bindValue(':ref_post', $id_reponse->getrefPost());
        $req -> execute();
    }

    public function supprimerReponse($id_reponse){
        $sql = "DELETE FROM reponse WHERE id_reponse = :id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse);
        $req->execute();
    }

    public function modifierReponse(Reponse $reponse){
        $sql = "UPDATE reponse SET contenu=:contenu,datetime_reponse=:datetime_reponse,ref_utilisateur=:ref_utilisateur,ref_post=:ref_post WHERE id_reponse=:id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $reponse->getIdReponse());
        $req->bindValue(':contenu', $reponse->getContenu());
        $req->bindValue(':datetime_reponse', $reponse->getDatetimeReponse());
        $req->bindValue(':ref_utilisateur', $reponse->getrefUtilisateur());
        $req->bindValue(':ref_post', $reponse->getrefPost());
        $req -> execute();
    }



}