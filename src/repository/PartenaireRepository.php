<?php
require_once "UtilisateurRepository.php";
class PartenaireRepository
{
    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getPartenaire($ref_utilisateur){
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN partenaire p ON u.id = p.ref_utilisateur WHERE p.ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $ref_utilisateur);
        $req->execute();
        $result = $req->fetch();
        $partenaire = new Partenaire($result["id_utilisateur"],$result["nom"],$result['prenom'], $result["email"],$result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["ref_utilisateur"],$result["poste_occupe"],$result["motif_inscription"],$result["ref_entreprise"]);
        return $partenaire;
    }

    public function getPartenaires(){
        $sql = "SELECT u.*, p.* FROM utilisateur u INNER JOIN partenaire p ON u.id = p.ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $partenaires = array();
        foreach ($result as $results) {
            $partenaires[] = new Partenaire($results["id_utilisateur"],$results["nom"],$results['prenom'], $results["email"],$results["mdp"],$results["date_inscription"],$result["statut_validation"],$results["ref_utilisateur"],$results["poste_occupe"],$results["motif_inscription"],$results["ref_entreprise"]);
        }
        return $partenaires;
    }


    public function ajoutPartenaire(Partenaire $partenaire){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajoutUtilisateur($partenaire);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO partenaire VALUES (:ref_utilisateur, :poste_occupe, :motif_inscription, :ref_entreprise)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(":motif_inscription",$partenaire-> getmotifInscription());
        $req->bindValue(":ref_entreprise",$partenaire-> getRefEntreprise());
        $req->execute();
    }

    public function modifierPartenaire(Partenaire $partenaire){
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->modifierUtilisateur($partenaire);
        $sql="UPDATE partenaire SET poste_occupe=:poste_occupe, motif_inscription=:motif_inscription, ref_promotion=:ref_entreprise WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $partenaire->getRefUtilisateur());
        $req->bindValue(':poste_occupe', $partenaire-> getPosteOccupe());
        $req->bindValue(":motif_inscription",$partenaire-> getMotifInscription());
        $req->bindValue(":ref_entreprise",$partenaire->getRefEntreprise());
        $req->bindValue(':ref_utilisateur', $partenaire->getRefUtilisateur());
        $req->execute();

    }
}
