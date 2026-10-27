<?php

require_once "UtilisateurRepository.php";
class ProfesseurRepository{
private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getProfesseur($ref_utilisateur){
        $sql = "SELECT u.* , p.ref_utilisateur FROM utilisateur u INNER JOIN  professeur p ON u.id_utilisateur = p.ref_utilisateur WHERE p.ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue('ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $professeur = new Professeur($result["id_utilisateur"],$result["nom"],$result['prenom'], $result["email"],$result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["specialite"],$result["ref_utilisateur"]);
        return $professeur;

    }

    public function getAllProfesseurs() {
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN professeur p ON u.id_utilisateur = p.ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $professeurs = array();
        foreach ($result as $results) {
            $professeurs[] = new Professeur($results["id_utilisateur"],$results["nom"],$results['prenom'], $results["email"],$results["mdp"],$results["date_inscription"],$results["statut_validation"],$results["specialite"],$results["ref_utilisateur"]);
        }
        return $professeurs;
    }


    public function ajoutProfesseur(Professeur $professeur){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId = $utilisateurRepository->ajoutUtilisateur($professeur);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO professeur VALUES(:ref_utilisateur, :specialite)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue('ref_utlisateur', $lastId);
        $req->bindValue('specialite', $professeur->getSpecialite());
        $req->execute();
    }

   public function modifierProfesseur(Professeur $professeur){
       $utilisateurRepository = new UtilisateurRepository();
       $utilisateurRepository->modifierUtilisateur($professeur);
      $sql="UPDATE professeur SET specialite = :specialite WHERE ref_utilisateur = :ref_utilisateur";
      $req = $this->connexionBdd->prepare($sql);
      $req->bindValue("ref_utilisateur", $professeur->getRefProfesseur());
      $req->bindValue('specialite', $professeur->getSpecialite());
      $req->execute();
   }



}