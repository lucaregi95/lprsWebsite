<?php
require_once "UtilisateurRepository.php";
require_once __DIR__ . "/../../bdd/bdd.php";
class PartenaireRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getPartenaire($id_partenaire){
        $sql = "SELECT u.* ,p.* FROM utilisateur u INNER JOIN partenaire p ON u.id_utilisateur = p.ref_utilisateur WHERE p.ref_utilisateur = :ref_utilisateur ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_partenaire);
        $req->execute();
        $result = $req->fetch();
        $partenaire = new Partenaire($result["id_utilisateur"], $result["nom"], $result["prenom"], $result["email"], $result["mdp"], $result["date_inscription"], $result["statut_validation"], $result["ref_utilisateur"],$result["poste_occupe"], $result["motif_inscription"], $result["ref_entreprise"]);
        return $partenaire;
    }

    public function getAllPartenaires(){
        $sql = "SELECT * FROM partenaire";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabPartenaire = array();
        foreach ($result as $results) {
            $tabPartenaire[] = new Partenaire($results["ref_utilisateur"],$results["poste_occupe"], $result["motif_inscription"], $result["ref_entreprise"]);
        }
        return $tabPartenaire;
    }

    public function ajouterPartenaire(Partenaire $partenaire){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajouterUtilisateur($partenaire);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO partenaire VALUES (:ref_utilisateur, :poste_occupe, :motif_inscription, :ref_entreprise)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(":motif_inscription",$partenaire-> getmotifInscription());
        $req->bindValue(":ref_entreprise",$partenaire-> getRefEntreprise());
        $req->execute();
    }

    public function modifierPartenaire(Partenaire $partenaire){
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->modifierUtilisateur($partenaire);
        $sql="UPDATE partenaire SET  poste_occupe = :poste_occupe, motif_inscription = :motif_inscription, ref_entreprise = :ref_entreprise WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire-> getRefUtilisateur());
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(':motif_inscription', $partenaire-> getMotifInscription());
        $req->bindValue(':ref_entreprise', $partenaire-> getRefEntreprise());

        $req->execute();

    }
}