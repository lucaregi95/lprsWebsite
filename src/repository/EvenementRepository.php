<?php

class EvenementRepository{

    private $connexionBdd;
    public function __construct()
    {
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getEvenement($id_evenement){
        $sql = "SELECT * FROM evenement WHERE id_evenement = :id_evenement ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $id_evenement);
        $req->execute();
        $result = $req->fetch();
        $evenement = new Evenement($result['id_evenement'],$result['titre'],$result['description'],$result['lieu'],$result['nbr_places']);
        return $evenement;

    }

    public function getAllEvenements(){
        $sql = "SELECT * FROM evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabEvenement = array();
        foreach($result as $results){
            $evenement = new Evenement($results['id_evenement'],$results['titre'],$results['description'],$results['lieu'],$results['nbr_places']);
        $tabEvenement[] = $evenement;
        }
        return $tabEvenement;
    }

    public function ajouterEvenement(Evenement $evenement){
        $sql = "INSERT INTO evenement (titre,description,lieu,nbr_places) VALUES (:titre,:description,:lieu,:nbr_places)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':titre', $evenement->getTitre());
        $req->bindValue(':description', $evenement->getDescription());
        $req->bindValue(':lieu', $evenement->getLieu());
        $req->bindValue(':nbr_places', $evenement->getNbrPlaces());
        $req -> execute();
    }


    public function supprimerEvenement($id_evenement){
        $sql = "DELETE FROM evenement WHERE id_evenement = :id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $id_evenement);
        $req->execute();
    }

    public function modifierEvenement(Evenement $evenement){
        $sql = "UPDATE evenement SET titre=:titre,description=:description,lieu=:lieu,nbr_places=:nbr_places WHERE id_evenement=:id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $evenement->getIdEvenement());
        $req->bindValue(':titre', $evenement->getTitre());
        $req->bindValue(':description', $evenement->getDescription());
        $req->bindValue(':lieu', $evenement->getLieu());
        $req->bindValue(':nbr_places', $evenement->getNbrPlaces());
        $req -> execute();
    }




}