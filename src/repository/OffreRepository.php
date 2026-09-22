<?php
class OffreRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getOffre($id_offre){
        $sql = "SELECT * FROM offre WHERE id_offre = :id_offre";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_offre', $id_offre);
        $req->execute();
        $result = $req->fetch();
        $offre = new Offre($result["id_offre"],$result["titre"], $result["description"], $result["mission"], $result["salaire"], $result["type_offre"], $result["etat"], $result["ref_entreprise"]); //ancienne presence d'un ] en trop dans id... a verifier dans tous les fichiers concernés
        return $offre;
    }

    public function getOffres(){ // a verifier pluriel ou pas dans tous les fichies
        $sql = "SELECT * FROM offre";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabOffre = array();
        foreach ($result as $results) {
            $tabOffre[] = new Offre($results["id_offre]"],$results["tirre"], $result["description"], $result["mission"], $result["salaire"], $result["type_offre"], $result["etat"], $result["ref_entreprise"]);
        }
        return $tabOffre;
    }


    public function ajoutOffre(Offre $offre){
        $sql="INSERT INTO offre VALUES (:id_offre,:titre, :description, :mission, :salaire, :type_offre, :etat, :ref_entreprise)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_offre', $offre-> getIdOffre());;
        $req->bindValue(":titre",$offre-> getTitre());
        $req->bindValue(":description",$offre-> getDescription());
        $req->bindValue(":mission",$offre-> getMission());
        $req->bindValue(":salaire",$offre-> getSalaire());
        $req->bindValue(":type_offre",$offre-> gettypeOffre());
        $req->bindValue(":etat",$offre-> getEtat());
        $req->bindValue(":ref_entreprise",$offre-> getRefEntreprise());
        $req->execute();
    }

    public function modifierOffre(Offre $offre){
        $sql="UPDATE offre SET titre = :titre, description = :description, mission = :mission, salaire = :salaire, type_offre = :type_offre, etat = :etat, ref_entreprise = :ref_entreprise WHERE id_offre = :id_offre";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':titre', $offre-> getTitre());
        $req->bindValue(':description', $offre-> getDescription());
        $req->bindValue(':mission', $offre-> getMission());
        $req->bindValue(':salaire', $offre-> getSalaire());
        $req->bindValue(':type_offre', $offre-> getTypeOffre());
        $req->bindValue(':etat', $offre-> getEtat());
        $req->bindValue(':ref_entreprise', $offre-> getRefEntreprise());
        $req->bindValue(':id_offre', $offre-> getIdOffre());
        $req->execute();

    }
}