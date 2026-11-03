<?php
require_once "UtilisateurRepository.php";
require_once __DIR__ . "/../../bdd/bdd.php";
class GestionnaireRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getGestionnaire($id_gestionnaire)
    {
        $sql = "SELECT u.* ,g.* FROM utilisateur u INNER JOIN gestionnaire g ON u.id_utilisateur = g.ref_utilisateur WHERE g.ref_utilisateur = :ref_utilisateur ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_gestionnaire);
        $req->execute();
        $result = $req->fetch();

        $gestionnaire = new Gestionnaire($result["id_utilisateur"], $result["nom"], $result["prenom"], $result["email"], $result["mdp"], $result["date_inscription"], $result["statut_validation"], $result["ref_utilisateur"]);
        return $gestionnaire;
    }

    public function getAllGestionnaires()
    {
        $sql = "SELECT u.*, g.* FROM utilisateur u INNER JOIN gestionnaire g ON u.id_utilisateur = g.ref_utilisateur";

        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabGestionnaire = array();
        foreach ($result as $results) {
            $tabGestionnaire[] = new Gestionnaire($results["id_utilisateur"], $results["nom"], $results["prenom"], $results["email"], $results["mdp"], $results["date_inscription"], $results["statut_validation"], $results["ref_utilisateur"]);
        }
        return $tabGestionnaire;
    }


    public function ajoutGestionnaire(Gestionnaire $gestionnaire){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajoutUtilisateur($gestionnaire);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO gestionnaire VALUES (:ref_utilisateur)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->execute();

    }

    public function modifierGestionnaire(Gestionnaire $gestionnaire){
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->modifierUtilisateur($gestionnaire);


    }
}
