<?php

class ProfesseurFormationRepository{
    private $connexionBdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }


    public function getProfesseurFormation($id_pF){
        $sql = "SELECT * FROM professeurformation WHERE id_pF = ?";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('id_pF', $id_pF);
        $req->execute();
        $resultat = $req->fetch();
    }

    public function getAllProfesseurFormation(){
        $sql = "SELECT * FROM professeurformation";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabProfesseurFormation = array();
        foreach($results as $result){
            $tabProfesseurFormation[] = new ProfesseurFormation($result["id_post"],$result["contenu"],$result["date"],$result["heure"]);
        }
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
        $req->bindValue('id_pF', $professeurFormation->getIdProfesseurFormation());
        $req->bindValue('ref_professeur',$professeurFormation->getRefProfesseur());
        $req->execute();
    }

}