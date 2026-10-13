<?php
require_once "../model/ProfesseurFormation.php";

class ProfesseurFormationRepository{
    private $connexionBdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }


    public function getProfesseursFormation($id_pF){
        $sql = "SELECT * FROM professeurformation WHERE id_pF = :id_pF";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('id_pF', $id_pF);
        $req->execute();
        $resultat = $req->fetch();
        $professeurFormation[] = new ProfesseurFormation($resultat['id_pF'],$resultat['ref_professeur'],$resultat['ref_formation']);
        return $professeurFormation;
    }

    public function getProfesseursFormations(){
        $sql = "SELECT * FROM professeurformation";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $resultat = $req->fetchAll();
        $tabProfesseurFormation = array();
        foreach($resultat as $results) {
            $tabProfesseurFormation[] = new ProfesseurFormation($results['id_pF'], $results['ref_professeur'], $results['ref_formation']);
        }
            return $tabProfesseurFormation;
    }

    public function ajoutProfesseurFormations(ProfesseurFormation $professeurFormation){
       $sql = "INSERT INTO professeurformation VALUES (:id_pF,:ref_professeur,:ref_formation)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue("id_pF", $professeurFormation-> getIdPf());
        $req->bindValue('ref_professeur',$professeurFormation->getRefProfesseur());
        $req->bindValue('ref_formation',$professeurFormation-> getRefFormation());
        $req->execute();

    }

    public function modifierProfesseurFormations(ProfesseurFormation$professeurFormation){
        $sql = "UPDATE professeurformation SET ref_professeur = :ref_professeur, ref_formation = :ref_formation WHERE id_pF = :id_pF";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('id_pF', $professeurFormation->getIdPf());
        $req->bindValue('ref_professeur',$professeurFormation->getRefProfesseur());
        $req->execute();
    }

    public function supprimerProfesseurFormation($id_pF){
        $sql = "DELETE FROM professeurformation WHERE id_pF = :id_pF";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('id_pF', $id_pF);
        $req->execute();
    }

}