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








}