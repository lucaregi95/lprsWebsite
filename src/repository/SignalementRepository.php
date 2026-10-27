<?php

class SignalementRepository{

    private $connexionBdd;
    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getSignalement($id_signalement){
        $sql = "SELECT * FROM signalement WHERE id_signalement = :id_signalement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_signalement', $id_signalement);
        $req->execute();
        $result = $req->fetch();
        $signalement = new Signalement ($result['id_signalement'],$result['date'],$result['contenu'],$result['titre'],$result['ref_signale'],$result['ref_signalant']);

        return $signalement;

    }

    public function getAllSignalements(){
        $sql = "SELECT * FROM signalement";
        $req = $this->connexionbdd->query($sql);
        $req = $req->execute();
        $result = $req->fetchAll();
        $signalements = array();
        foreach ($result as $results) {
            $signalements[] = new Signalement($results["id_signalement"],$results["date"],$results["ref_signalant"],$results["ref_signale"],$results["titre"],$results["contenu"]);
        }
        return $signalements;
    }


    public function ajoutSignalement(Signalement $signalement){
        $sql = "INSERT INTO signalement VALUES (:id_signalement,:date,:ref_signalant,:ref_signale,:titre,:contenu)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_signalement',$signalement->getIdSignalement());
        $req->bindValue(':date',$signalement->getDate());
        $req->bindValue(':ref_signalant',$signalement->getRefSignalant());
        $req->bindValue(':ref_signale',$signalement->getRefSignale());
        $req->bindValue(':titre',$signalement->getTitre());
        $req->bindValue(':contenu',$signalement->getContenu());
        $req->execute();
    }

    public function modifierSignalement(Signalement $signalement){
        $sql = "UPDATE signalement SET date = :date,contenu = :contenu WHERE id_signalement = :id_signalement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':date',$signalement->getDate());
        $req->bindValue(':contenu',$signalement->getContenu());
        $req->bindValue(':id_signalement',$signalement->getIdSignalement());
        $req->execute();
    }
}