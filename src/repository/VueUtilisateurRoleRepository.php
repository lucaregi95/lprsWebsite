<?php
require_once __DIR__ . "/../../bdd/bdd.php";

class VueUtilisateurRoleRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getAllUtilisateurWithRoles(){
        $sql = "SELECT * FROM v_utilisateurwithrole";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabUtilisateur = array();
        foreach ($results as $result) {
            $tabUtilisateur[] = new VueUtilisateurRole($result["id_acteur"],$result["nom"],$result["prenom"],$result["email"], $result["mdp"],$result["date_naissance"],$result["tel"],$result["rue"],$result["ville"],$result["cp"],$result["role"],$result["etat"]);
        }
        return $tabUtilisateur;
    }
}