<?php
class FormationRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getFormation($id_formation){
        $sql = "SELECT * FROM formation WHERE id_formation = :id_formation";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_formation', $id_formation);
        $req->execute();
        $result = $req->fetch();
        $formation = new Formation($result["id_formation"],$result["nom_formation"]); //ancienne presence d'un ] en trop dans id... a verifier dans tous les fichiers concernés
        return $formation;
    }

    public function getFormations(){ // a verifier pluriel ou pas dans tous les fichies
        $sql = "SELECT * FROM formation";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $formations = array();
        foreach ($result as $results) {
            $tabFormation[] = new Formation($results["id_formation]"],$results["nom_formation"]);
        }
        return $formations;
    }


    public function ajoutFormation(Formation $formation){
        $sql="INSERT INTO formation VALUES (:id_formation,:nom_formation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_formation', $formation-> getIdFormation());;
        $req->bindValue(":addressse",$formation-> getNomFormation());
        $req->execute();
    }

    public function modifierFormation(Formation $formation){
        $sql="UPDATE formation SET nom_formation = :nom_formation WHERE id_formation = :id_formation";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':nom_formation', $formation-> getNomFormation());
        $req->bindValue(':id_formation',$formation-> getIdFormation());
        $req->execute();

    }
}