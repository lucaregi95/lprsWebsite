<?php
require_once "UtilisateurRepository.php";
class EtudiantRepository
{
    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getEtudiant($id_etudiant){
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN etudiant e ON u.id = e.ref_utilisateur WHERE e.ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_etudiant);
        $req->execute();
        $result = $req->fetch();
        $etudiant = new Etudiant($result["id_utilisateur"],$result["nom"],$result['prenom'], $result["email"],$result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["ref_utilisateur"],$result["cv"],$result["ref_formation"],$result["ref_promotion"]);
        return $etudiant;
    }

    public function getEtudiants(){
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN etudiant e ON u.id = e.ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $etudiants = array();
        foreach ($result as $results) {
            $etudiants[] = new Etudiant($results["id_utilisateur"],$results["nom"],$results['prenom'], $results["email"],$results["mdp"],$results["date_inscription"],$results["statut_validation"],$results["ref_utilisateur"],$results["cv"],$results["ref_formation"],$results["ref_promotion"]);
        }
        return $etudiants;
    }


    public function ajoutEtudiant(Etudiant $etudiant){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajoutUtilisateur($etudiant);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO etudiant VALUES (:ref_utilisateur, :cv, :ref_formation, :ref_promotion)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->bindValue(':cv', $etudiant-> getCV());
        $req->bindValue(":ref_formation",$etudiant-> getRefFormation());
        $req->bindValue(":ref_promotion",$etudiant-> getRefPromotion());
        $req->execute();
        $etudiant->setIdUtilisateur($lastId);
        return $etudiant;
    }

    public function modifierEtudiant(Etudiant $etudiant){
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->modifierUtilisateur($etudiant);
        $sql="UPDATE etudiant SET cv = :cv, ref_formation=:ref_formation, ref_promotion=:ref_promotion WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':cv', $etudiant-> getCV());
        $req->bindValue(':ref_promotion',$etudiant-> getRefPromotion());
        $req->bindValue(':ref_formation',$etudiant-> getRefFormation());
        $req->bindValue(':ref_utilisateur',$etudiant-> getRefUtilisateur());
        $req->execute();

    }
}
