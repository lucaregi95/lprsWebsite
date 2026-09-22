<?php

class reponseRepository{

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
        $reponse = new Reponse($result['id_reponse'],$result['contenu'],$result['date_reponse'],$result['ref_inscrit'],$result['ref_sujet']);
        return $reponse;

    }

    public function getAllReponses(){
        $sql = "SELECT * FROM reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabReponse = array();
        foreach($result as $row){
            $reponse = new Reponse($result['$id_reponse'],$result['contenu'],$result['date_reponse'],$result['ref_inscrit'],$result['ref_sujet']);

            $tabReponse[] = $reponse;
        }
        return $tabReponse;
    }

    public function ajouterReponse(Reponse $id_reponse){
        $sql = "INSERT INTO reponse (contenu,date_reponse,ref_inscrit,ref_sujet) VALUES (:contenu,:date_reponse,:ref_inscrit,:ref_sujet)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse->getIdReponse());
        $req->bindValue(':contenu', $id_reponse->getContenu());
        $req->bindValue(':date_reponse', $id_reponse->getDateReponse());
        $req->bindValue(':ref_inscrit', $id_reponse->getRefInscrit());
        $req->bindValue(':ref_sujet', $id_reponse->getRefSujet());
        $req -> execute();
    }

    public function supprimerReponse($id_reponse){
        $sql = "DELETE FROM reponse WHERE id_reponse = :id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse);
        $req->execute();
    }

    public function modifierReponse(Reponse $reponse){
        $sql = "UPDATE reponse SET contenu=:contenu,date_reponse=:date_reponse,ref_inscrit=:ref_inscrit,ref_sujet=:ref_sujet WHERE id_reponse=:id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $reponse->getIdReponse());
        $req->bindValue(':contenu', $reponse->getContenu());
        $req->bindValue(':date_reponse', $reponse->getDateReponse());
        $req->bindValue(':ref_inscrit', $reponse->getRefInscrit());
        $req->bindValue(':ref_sujet', $reponse->getRefSujet());
        $req -> execute();
    }



}