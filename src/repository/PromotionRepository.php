<?php
class PromotionRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getPromotion($id_promotion){
        $sql = "SELECT * FROM promotion WHERE id_promotion = :id_promotion";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_promotion', $id_promotion);
        $req->execute();
        $result = $req->fetch();
        $promotion = new Promotion($result["id_promotion"],$result["annee"]);
        return $promotion;
    }

    public function getAllPromotion(){
        $sql = "SELECT * FROM promotion";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabPromotion = array();
        foreach ($results as $result) {
            $tabPromotion[] = new Promotion($result["id_promotion]"],$result["annee"]);
        }
        return $tabPromotion;
    }


    public function ajoutPromotion(Promotion $promotion){
        $sql="INSERT INTO promotion VALUES (:id_promotion,:annee)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':id_promotion', $promotion-> getIdPromotion());;
        $req->bindValue(":annee",$promotion-> getAnnee());
        $req->execute();
    }

    public function modifierPromotion(Promotion $promotion){
        $sql="UPDATE promotion SET annee = :annee WHERE id_promotion = :id_promotion";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':annee', $promotion-> getannee());
        $req->bindValue(':id_promotion', $promotion-> getIdPromotion());
        $req->execute();

    }
}