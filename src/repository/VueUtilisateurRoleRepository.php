<?php

require_once __DIR__ . "/../../bdd/bdd.php";

class VueUtilisateurRoleRepository{

    private $connexionBdd;

    public function __construct(){
        $this->connexionBdd = (new Bdd())->getConnexionBdd();
    }

    public function getAllUtilisateurWithRoles(){
        $sql = "SELECT * FROM v_utilisateurwithrole";
        $req = $this->connexionBdd->prepare($sql);
        $req->execute();
        $results = $req->fetchAll();
        $tabUtilisateur = array();
        foreach ($results as $result) {
            $tabUtilisateur[] = new VueUtilisateurRole($result["id_utilisateur"],$result["nom"],$result["prenom"],$result["email"], $result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["role"]);
        }
        return $tabUtilisateur;
    }

    public function getAllUtilisateurWithRolesEnAttente(){
        $sql = "SELECT * FROM v_utilisateurwithrole WHERE statut_validation='En attente'";
        $req = $this->connexionBdd->prepare($sql);

        $req->execute();
        $results = $req->fetchAll();
        $tabUtilisateur = array();
        foreach ($results as $result) {
            $tabUtilisateur[] = new VueUtilisateurRole($result["id_utilisateur"],$result["nom"],$result["prenom"],$result["email"], $result["mdp"],$result["date_inscription"],$result["statut_validation"],$result["role"]);
        }
        return $tabUtilisateur;
    }
}