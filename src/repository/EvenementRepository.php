<?php

class EvenementRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getEvenements($id_evenement){
        $sql = "SELECT * FROM evenement WHERE id_evenement = :id_evenement ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindParam(':id_evenement', $id_evenement);
        $req->execute();
        $result = $req->fetch();
        $evenement = new Evenement($result['id_evenement'],$result['titre'],$result['description'],$result['lieu'],$result['element_requis'],$result['nbr_places']);
        return $evenement;

    }

    public function getAllEvenement(){
        $sql = "SELECT * FROM evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabEvenement = array();
        foreach($result as $row){
            $evenement = new Evenement($result['id_evenement'],$result['titre'],$result['description'],$result['lieu'],$result['element_requis'],$result['nbr_places']);

        $tabEvenement[] = $evenement;
        }
        return $tabEvenement;
    }

    public function ajouterEvenement(Evenement $id_evenement){
        $sql = "";
    }




}