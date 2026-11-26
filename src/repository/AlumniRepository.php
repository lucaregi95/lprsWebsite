<?php
require_once "UtilisateurRepository.php";
require_once __DIR__ . "/../../bdd/bdd.php";
class AlumniRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getAlumni($id_alumni)
    {
        $sql = "SELECT u.* ,a.* FROM utilisateur u INNER JOIN alumni a ON u.id_utilisateur = a.ref_utilisateur WHERE a.ref_utilisateur = :ref_utilisateur ";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $id_alumni);
        $req->execute();
        $result = $req->fetch();

        $alumni = new Alumni($result["id_utilisateur"], $result["nom"], $result["prenom"], $result["email"], $result["mdp"], $result["date_inscription"], $result["statut_validation"], $result["ref_utilisateur"], $result["cv"], $result["poste_occupe"], $result["ref_promotion"], $result["ref_entreprise"]);
        return $alumni;
    }

    public function getAllAlumnis()
    {
        $sql = "SELECT u.*, a.* FROM utilisateur u INNER JOIN alumni a ON u.id_utilisateur = a.ref_utilisateur";

        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $tabAlumni = array();
        foreach ($result as $results) {
            $tabAlumni[] = new Alumni($results["id_utilisateur"], $results["nom"], $results["prenom"], $results["email"], $results["mdp"], $results["date_inscription"], $results["statut_validation"], $results["ref_utilisateur"], $results["cv"], $results["poste_occupe"], $results["ref_promotion"], $results["ref_entreprise"]);
        }
        return $tabAlumni;
    }


    public function ajouterAlumni(Alumni $alumni){
        $utilisateurRepository = new UtilisateurRepository();
        $lastId=$utilisateurRepository->ajouterUtilisateur($alumni);
        if($lastId==0){
            return null;
        }
        $sql="INSERT INTO alumni VALUES (:ref_utilisateur,:cv,:poste_occupe,:ref_promotion, :ref_entreprise)";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':ref_utilisateur', $lastId);
        $req->bindValue(':cv', $alumni-> getCv());
        $req->bindValue(':poste_occupe', $alumni-> getPosteOccupe());
        $req->bindValue(':ref_promotion' , $alumni-> getRefPromotion());
        $req->bindValue(':ref_entreprise' , $alumni-> getRefEntreprise());
        $req->execute();

    }

    public function modifierAlumni(Alumni $alumni){
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->modifierUtilisateur($alumni);
        $sql="UPDATE alumni SET cv = :cv, poste_occupe =:poste_occupe, ref_promotion=:ref_promotion, ref_entreprise=:ref_entreprise WHERE ref_utilisateur = :ref_utilisateur";
        $req = $this->connexionBdd->prepare($sql);
        $req->bindValue(':cv', $alumni-> getCV());
        $req->bindValue(':poste_occupe',$alumni-> getPosteOccupe());
        $req->bindValue(':ref_promotion',$alumni-> getRefPromotion());
        $req->bindValue(':ref_entreprise',$alumni-> getRefEntreprise());
        $req->bindValue(':ref_utilisateur',$alumni-> getRefUtilisateur());
        $req->execute();

    }

    /**
     * Cette methode sert à trier les alumnis en fonction des filtres.
     *
     *
     * @param array $filtres liste des filtres disponibles
     * @return array renvoie la liste des alumnis concernés par les filtres
     */

    public function getAlumnisFiltres(array $filtres): array
    {
        $sql = "SELECT u.*, a.* 
            FROM utilisateur u 
            INNER JOIN alumni a ON u.id_utilisateur = a.ref_utilisateur";
        $params = [];

        if (!empty($filtres['nom'])) {
            $sql .= " AND (u.nom LIKE :nom OR u.prenom LIKE :prenom)";
            $params[':nom'] = '%' . $filtres['nom'] . '%';
            $params[':prenom'] = '%' . $filtres['nom'] . '%';
        }
        if (!empty($filtres['promotion'])) {
            $sql .= " AND a.ref_promotion = :promotion";
            $params[':promotion'] = $filtres['promotion'];
        }
        if (!empty($filtres['entreprise'])) {
            $sql .= " AND a.ref_entreprise = :entreprise";
            $params[':entreprise'] = $filtres['entreprise'];
        }
        if (!empty($filtres['poste'])) {
            $sql .= " AND a.poste_occupe LIKE :poste";
            $params[':poste'] = '%' . $filtres['poste'] . '%';
        }

        $stmt = $this->connexionBdd->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();

        $tabAlumnis = array();
        foreach ($result as $results) {
            $tabAlumnis[] = new Alumni($results["id_utilisateur"], $results["nom"], $results["prenom"], $results["email"], $results["mdp"], $results["date_inscription"], $results["statut_validation"], $results["ref_utilisateur"], $results["cv"], $results["poste_occupe"], $results["ref_promotion"], $results["ref_entreprise"]);
        }
        return $tabAlumnis;
    }
}