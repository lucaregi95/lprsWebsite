<?php
require_once "UtilisateurRepository.php";
class AlumniRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getAlumni($id_alumni)
    {
        $sql = "SELECT u.* ,a.* FROM utilisateur u INNER JOIN alumni e ON u.id = a.ref_utilisateur WHERE e.ref_utilisateur = :ref_utilisateur ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_alumni);
        $req->execute();
        $result = $req->fetch();
        $alumni = new Alumni($result["id_utilisateur"], $result["nom"], $result["prenom"], $result["email"], $result["mdp"], $result["date_inscription"], $result["statut_validation"], $result["ref_utilisateur"], $result["cv"], $result["poste_occupe"], $result["ref_promotion"], $result["ref_entreprise"]);
        return $alumni;
    }

    public function getAllAlumni()
    {
        $sql = "SELECT u.*, e.* FROM utilisateur u INNER JOIN alumni a ON u.id = a.ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $alumnis = array();
        foreach ($result as $results) {
            $alumnis[] = new Alumni($result["id_utilisateur"], $result["nom"], $result["prenom"], $result["email"], $result["mdp"], $result["date_inscription"], $result["statut_validation"], $result["ref_utilisateur"], $result["cv"], $result["poste_occupe"], $result["ref_promotion"], $result["ref_entreprise"]);
        }
        return $tabAlumni;
    }


    public function ajoutAlumni(Alumni $alumni){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajoutUtilisateur($alumni);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO alumni VALUES (:ref_utilisateur,:cv,:poste_occupe,:ref_promotion, :ref_entreprise)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->bindValue('poste_occupe', $alumni-> getPosteOccupe());
        $req->bindValue('ref_promotion' , $alumni-> getRefPromotion());
        $req->bindValue('ref_entrprise' , $alumni-> getRefEntreprise());
        $req->execute();

    }

    public function modifierAlumni(Alumni $alumni){
        $sql="UPDATE alumni SET cv = :cv, poste_occupe =:poste_occupe, ref_promotion=:ref_promotion, ref_entreprise=:ref_entreprise WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':cv', $alumni-> getCV());
        $req->bindValue(':poste_occupe',$alumni-> getPosteOccupe());
        $req->bindValue(':ref_promotion',$alumni-> getRefPromotion());
        $req->bindValue(':ref_entreprise',$alumni-> getRefEntreprise());
        $req->bindValue(':ref_utilisateur',$alumni-> getRefUtilisateur());
        $req->execute();

    }
}