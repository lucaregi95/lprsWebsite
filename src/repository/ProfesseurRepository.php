<?php
class ProfesseurRepository{
private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getProfesseur($ref_utilisateur){
        $sql = "SELECT u.* , p. ref_professeur FROM utilisateur u INNER JOIN  professeur p ON id_utilisateur = ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue('ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $professeur = new Professeur($result["id_utilisateur"],$result["nom"],$result['prenom'], $result["email"],$result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["specialite"],$result["ref_utilisateur"]);
        return $professeur;

    }

    public function getProfesseurs() {
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN professeur p ON u.id_utilisateur = p.ref_utilisateur";
        $req = $this->connexionbdd->query($sql);
        $req = $req->execute();
        $result = $req->fetchAll();
        $professeurs = array();
        foreach ($result as $results) {
            $professeurs[] = new Professeur($results["id_utilisateur"],$result["nom"],$result['prenom'], $result["email"],$result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["specialite"],$result["ref_utilisateur"]);
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