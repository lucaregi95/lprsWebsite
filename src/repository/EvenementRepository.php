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
        $req->bindValue(':id_evenement', $id_evenement);
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
        $sql = "INSERT INTO evenement (titre,description,lieu,element_requis,nbr_places) VALUES (:id_evenement,:titre,:description,:lieu,:element_requis,:nbr_places)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $id_evenement->getIdEvenement())
        $req->bindValue(':titre', $id_evenement->getTitre());
        $req->bindValue(':description', $id_evenement->getDescription());
        $req->bindValue(':lieu', $id_evenement->getLieu());
        $req->bindValue(':element_requis', $id_evenement->getElementRequis());
        $req->bindValue(':nbr_places', $id_evenement->getNbrPlaces());
        $req -> execute();
    }

    public function supprimerEvenement($id_evenement){
        $sql = "DELETE FROM evenement WHERE id_evenement = :id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $id_evenement);
        $req->execute();
    }

    public function modifierEvenement(Evenement $evenement){
        $sql = "UPDATE evenement SET titre=:titre,description=:description,lieu=:lieu,element_requis=:element_requis,nbr_places=:nbr_places WHERE id_evenement=:id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $evenement->getIdEvenement());
        $req->bindValue(':titre', $evenement->getTitre());
        $req->bindValue(':description', $evenement->getDescription());
        $req->bindValue(':lieu', $evenement->getLieu());
        $req->bindValue(':element_requis', $evenement->getElementRequis());
        $req->bindValue(':nbr_places', $evenement->getNbrPlaces());
        $req -> execute();
    }




}