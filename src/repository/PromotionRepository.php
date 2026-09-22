<?php
class PromotionRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getPromotion($id_promotion){
        $sql = "SELECT * FROM promotion WHERE id_promotion = :id_promotion";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_promotion', $id_promotion);
        $req->execute();
        $result = $req->fetch();
        $promotion = new Promotion($result["id_promotion"],$result["annee"]);
        return $promotion;
    }

    public function getPromotions(){ // a verifier pluriel ou pas dans tous les fichies
        $sql = "SELECT * FROM promotion";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $promotion = array();
        foreach ($result as $results) {
            $tabPromotion[] = new Promotion($results["id_promotion]"],$results["annee"]);
        }
        return $tabPromotion;
    }


    public function ajoutPromotion(Promotion $promotion){
        $sql="INSERT INTO promotion VALUES (:id_promotion,:annee)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_promotion', $promotion-> getIdPromotion());;
        $req->bindValue(":annee",$promotion-> getAnnee());
        $req->execute();
    }

    public function modifierPromotion(Promotion $promotion){
        $sql="UPDATE promotion SET annee = :annee WHERE id_promotion = :id_promotion";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':annee', $promotion-> getannee());
        $req->bindValue(':id_promotion', $promotion-> getIdPromotion());
        $req->execute();

    }
}