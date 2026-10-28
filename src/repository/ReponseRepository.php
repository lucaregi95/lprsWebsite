<?php
require_once __DIR__ . "/../../bdd/bdd.php";
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
        $reponse = new Reponse($result['id_reponse'],$result['contenu'],$result['datetime_reponse'],$result['ref_post'],$result['ref_post']);
        return $reponse;

    }

    public function getAllReponses(){
        $sql = "SELECT * FROM reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabReponse = array();
        foreach($results as $result){
            $tabReponse[] = new Reponse($result['$id_reponse'],$result['contenu'],$result['datetime_reponse'],$result['ref_post'],$result['ref_utilisateur']);
        }
        return $tabReponse;
    }

    public function ajouterReponse(Reponse $id_reponse){
        $sql = "INSERT INTO reponse (contenu,date_reponse,ref_utilisateur,ref_post) VALUES (:contenu,:date_reponse,:ref_utilisateur,:ref_post)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse->getIdReponse());
        $req->bindValue(':contenu', $id_reponse->getContenu());
        $req->bindValue(':datetime_reponse', $id_reponse->getDatetimeReponse());
        $req->bindValue(':ref_post', $id_reponse->getRefPost());
        $req->bindValue(':ref_utilisateur', $id_reponse->getRefUtilisateur());
        $req -> execute();
    }

    public function supprimerReponse($id_reponse){
        $sql = "DELETE FROM reponse WHERE id_reponse = :id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $id_reponse);
        $req->execute();
    }

    public function modifierReponse(Reponse $reponse){
        $sql = "UPDATE reponse SET contenu=:contenu,datetime_reponse=:datetime_reponse WHERE id_reponse=:id_reponse";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':$id_reponse', $reponse->getIdReponse());
        $req->bindValue(':contenu', $reponse->getContenu());
        $req->bindValue(':date_reponse', $reponse->getDatetimeReponse());
        $req -> execute();
    }



}