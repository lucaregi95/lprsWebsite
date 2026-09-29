<?php
class ProfesseurRepository{
private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getProfesseur($ref_utilisateur){
        $sql = "SELECT * FROM professeur WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $professeur =  new Professeur($result['ref_utilisateur'], $result['specialite']);
        return $professeur;
    }

    public function getProfesseurs(){
        $sql = "SELECT * FROM professeur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabProfesseur = array();
        foreach($results as $result){
            $tabProfesseur[]= new Professeur(($result['ref_utilisateur']), $result['specialite']);}
        return $tabProfesseur;
        }


    public function ajoutProfesseur(Professeur $professeur){
        $sql="INSERT INTO professeur VALUES(:ref_utilisateur, :specialite)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue('ref_utlisateur', $professeur->getRefUtilisateur());
        $req->bindValue('specialite', $professeur->getSpecialite());
        $req->execute();
    }

   public function modifierProfesseur(Professeur $professeur){
      $sql="UPDATE professeur SET specialite = :specialite WHERE ref_utilisateur = :ref_utilisateur";
      $req = $this->connexionBdd->prepare($sql);
      $req->bindValue("ref_utilisateur", $professeur->getIdUtilisateur());
      $req->bindValue('specialite', $professeur->getSpecialite());
      $req->execute();
   }



}