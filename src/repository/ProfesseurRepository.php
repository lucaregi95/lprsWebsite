<?php
class ProfesseurRepository{
private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getProfesseur($ref_utilisateur){
        $sql = "SELECT u.* , p. ref_professeur FROM utilisateur u INNER JOIN  professeur p ON id_utilisateur = ref_utilisateur";
        $reqProfesseur = $this->connexionbdd->prepare($sql);
        $reqProfesseur->execute();
        $professeur = $reqProfesseur->fetchAll();
        return $professeur;
    }

    public function getProfesseurs() {
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN professeur p ON u.id_utilisateur = p.ref_utilisateur";
        $req = $this->connexionbdd->query($sql);
        return $req->fetchAll(PDO::FETCH_ASSOC);
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