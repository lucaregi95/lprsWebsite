<?php
class EntrepriseRepository{

    private $connexionbdd;

    public function __construct(){
        $this->connexionbdd = (new Bdd())->getConnexionBdd();
    }

    public function getEntreprise($id_entreprise){
        $sql = "SELECT * FROM entreprise WHERE id_entreprise = :id_entreprise";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_entreprise', $id_entreprise);
        $req->execute();
        $result = $req->fetch();
        $entreprise = new Entreprise($result["id_entreprise]"],$result["addresse"],$result['nom_entreprise'],$result['site_wab']);
        return $entreprise;
    }

    public function getEntreprises(){
        $sql = "SELECT * FROM entreprise";
        $req = $this->connexionbdd->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $entreprises = array();
        foreach ($result as $results) {
            $tabEntreprise[] = new Entreprise($results["id_entreprise]"],$results["addresse"],$results['nom_entreprise'],$results['site_web']);
        }
        return $entreprises;
    }


    public function ajoutEntreprise(Entreprise $entreprise){
        $sql="INSERT INTO entreprise VALUES (:id_entreprise,:addresse,:nom_entreprise,:site_web)";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':id_entreprise', $entreprise-> getidEntreprise());;
        $req->bindValue(":addressse",$entreprise-> getAdresse());
        $req->bindValue(":nom_entreprise",$entreprise-> getNomEntreprise());
        $req->bindValue(":site_web",$entreprise-> getSiteWeb());
        $req->execute();
    }

    public function modifierEntreprise(Entreprise $entreprise){
        $sql="UPDATE entreprise SET addresse = :addresse, nom_entreprise =:nom_entreprise, site_web=:site_web WHERE id_entreprise = :id_entreprise";
        $req = $this->connexionbdd->prepare($sql);
        $req->bindValue(':addresse', $entreprise-> getAdresse());
        $req->bindValue(':nom_entreprise',$entreprise-> getNomEntreprise());
        $req->bindValue(':site_web',$entreprise-> getSiteWeb());
        $req->bindValue(':id_entreprise',$entreprise-> getidEntreprise());
        $req->execute();

    }
}