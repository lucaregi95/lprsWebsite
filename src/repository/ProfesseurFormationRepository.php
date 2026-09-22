<?php

class ProfesseurFormationRepository{
    private $connexionBdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }


    public function getProfesseursFormation($id_pF){
        $sql = "SELECT * FROM professeurformation WHERE id_pF = ?";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('id_pF', $id_pF);
        $req->execute();
        $resultat = $req->fetch();
    }

    public function getProfesseursFormations(){
        $sql = "SELECT * FROM professeurformation";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $resultat = $req->fetchAll();
        $tabProfesseurFormation = array();
        return $tabProfesseurFormation;
    }

    public function ajoutProfesseurFormations(ProfesseurFormationRepository $professeurFormation){
       $sql = "INSERT INTO professeurformation VALUES (:id_pF,:ref_professeur,:ref_formation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue("id_pF", $professeurFormation-> getIdPf());
        $req->bindValue('ref_professeur',$professeurFormation->getRefProfesseur());
        $req->bindValue('ref_formation',$professeurFormation-> getFormation());
        $req->execute();

    }

    public function modifierProfesseurFormations(ProfesseurFormationRepository $professeurFormation){
        $sql = "UPDATE professeurformation SET ref_professeur = :ref_professeur, ref_formation = :ref_formation WHERE id_pF = :id_pF";
        $req = $this->connexionbdd->prepare($sql);
        $req
    }

}