<?php
class ProfesseurRepository{
private $connexionBdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getProfesseur($ref_utilisateur){
        $sql = "SELECT * FROM professeur WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $ref_utilisateur =  new Professeur($result['ref_utilisateur'], $result['specialite']);
    }

    public function getProfesseurs(){
        $sql = "SELECT * FROM professeur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $professeurs = array();
        foreach($result as $professeur){
            $tabProfesseur[]= new Professeur(($result['ref_utilisateur']), $result['specialite']);}
        return $professeurs;
        }


    public function ajoutProfesseur(Professeur $professeur){
        $sql="INSERT INTO professeur VALUES(:ref_utilisateur, :specialite)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('ref_utlisateur', $professeur->getRefUtilisateur());
        $req->bindValue('specialite', $professeur->getSpecialite());
    }

   public function modifierProfesseur(Professeur $professeur){
      $sql="UPDATE professeur SET specialite = :specialite WHERE ref_utilisateur = :ref_utilisateur";
      $req = $this->connexionbdd->prepare($sql);
      $req->bindValue("ref_utilisateur", $professeur->getIdUtilisateur());
      $req->bindValue('specialite', $professeur->getSpecialite());
   }



}