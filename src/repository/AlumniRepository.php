<?php
class AlumniRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getAlumni($id_alumni){
        $sql = "SELECT * FROM alumni WHERE id_alumni = :id_alumni";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_alumni', $id_alumni);
        $req->execute();
        $result = $req->fetch();
        $alumni = new Alumni($result["ref_utilisateur"],$result["cv"],$result['poste_occupe'],$result['ref_promotion'], $result["ref_entreprise"]);
        return $alumni;
    }

    public function getAlumnis(){
        $sql = "SELECT * FROM alumni";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $alumnis = array();
        foreach ($result as $results) {
            $tabAlumni[] = new Alumni($result["ref_utilisateur"],$result["cv"],$result['poste_occupe'],$result['ref_promotion'], $result["ref_entreprise"]);
        }
        return $alumnis;
    }


    public function ajoutAlumni(Alumni $alumni){
        $sql="INSERT INTO alumni VALUES (:ref_utilisateur,:cv,:poste_occupe,:ref_promotion, :ref_entreprise)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_entreprise', $alumni-> getRefUtilisateur());;
        $req->bindValue(":addressse",$alumni-> getCV());
        $req->bindValue(":poste_occupe",$alumni-> getPosteOccupe());
        $req->bindValue(":ref_promotion",$alumni-> getRefPromotion());
        $req->bindValue("ref_entreprise", $alumni->getRefEntrprise());
        $req->execute();
    }

    public function modifierAlumni(Alumni $alumni){
        $sql="UPDATE alumni SET cv = :cv, poste_occupe =:poste_occupe, ref_promotion=:ref_promotion, ref_entreprise=:ref_entreprise WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':cv', $alumni-> getCV());
        $req->bindValue(':poste_occupe',$alumni-> getPosteOccupe());
        $req->bindValue(':ref_promotion',$alumni-> getRefPromotion());
        $req->bindValue(':ref_entreprise',$alumni-> getRefEntreprise());
        $req->bindValue(':ref_utilisateur',$alumni-> getRefUtilisateur());
        $req->execute();

    }
}