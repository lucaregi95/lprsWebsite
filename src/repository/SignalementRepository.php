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
        $reponse = new Signalement ($result['id_signalement'],$result['date'],$result['contenu'],$result['titre'],$result['ref_signale'],$result['ref_signalant']);

        return $reponse;

    }

}