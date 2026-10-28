<?php
require_once __DIR__ . "/../../bdd/bdd.php";

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
        $evenement = new Evenement($result['id_evenement'],$result['titre'],$result['description'],$result['lieu'],$result['nbr_places'],$result['date_evenement']);
        return $evenement;

    }

    public function getAllEvenements(){
        $sql = "SELECT * FROM evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabEvenement = array();
        foreach($result as $results){
            $evenement = new Evenement($results['id_evenement'],$results['titre'],$results['description'],$results['lieu'],$results['nbr_places'],$results['lat'],$results['lng'],$results['date_evenement']);
        $tabEvenement[] = $evenement;
        }
        return $tabEvenement;
    }

    public function getEvenementsByUtilisateur($id_utilisateur){
        $sql = "SELECT e.* FROM evenement e INNER JOIN participe p ON p.ref_evenement = e.id_evenement WHERE p.ref_utilisateur = :id_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_utilisateur', $id_utilisateur);
        $req->execute();
        $result = $req->fetchAll();
        $tabEvenement = array();
        foreach($result as $results){
            $tabEvenement[] = new Evenement($results['id_evenement'],$results['titre'],$results['description'],$results['lieu'],$results['nbr_places'],$results['lat'],$results['lng'],$results['date_evenement']);
        }
        return $tabEvenement;
    }

    public function ajouterEvenement(Evenement $evenement){
        $sql = "INSERT INTO evenement (titre,description,lieu,nbr_places,lat,lng,date_evenement) VALUES (:titre,:description,:lieu,:nbr_places,:lat,:lng,:date_evenement)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':titre', $evenement->getTitre());
        $req->bindValue(':description', $evenement->getDescription());
        $req->bindValue(':lieu', $evenement->getLieu());
        $req->bindValue(':nbr_places', $evenement->getNbrPlaces());
        $req->bindValue(':lat', $evenement->getLat());
        $req->bindValue(':lng', $evenement->getLng());
        $req->bindValue(':date_evenement', $evenement->getDateEvenement());
        $req -> execute();
    }


    public function supprimerEvenement($id_evenement){
        $sql = "DELETE FROM evenement WHERE id_evenement = :id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $id_evenement);
        $req->execute();
    }

    public function modifierEvenement(Evenement $evenement){
        $sql = "UPDATE evenement SET titre=:titre,description=:description,lieu=:lieu,nbr_places=:nbr_places,lat=:lat,lng=:lng, date_evenement=:date_evenement WHERE id_evenement=:id_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_evenement', $evenement->getIdEvenement());
        $req->bindValue(':titre', $evenement->getTitre());
        $req->bindValue(':description', $evenement->getDescription());
        $req->bindValue(':lieu', $evenement->getLieu());
        $req->bindValue(':nbr_places', $evenement->getNbrPlaces());
        $req->bindValue(':lat', $evenement->getLat());
        $req->bindValue(':lng', $evenement->getLng());
        $req->bindValue(':date_evenement', $evenement->getDateEvenement());

        $req -> execute();
    }

    public function getNbInscritsParEvenement(){
        $sql = "SELECT ref_evenement, COUNT(*) AS nb FROM participe WHERE est_orga = 0 GROUP BY ref_evenement";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $tab = array();
        foreach($req->fetchAll() as $row){
            $tab[$row['ref_evenement']] = (int)$row['nb'];
        }
        return $tab;
    }




}