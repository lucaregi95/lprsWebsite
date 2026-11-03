<?php

require_once "../src/model/Utilisateur.php";
require_once "../src/repository/UtilisateurRepository.php";
$rep = new UtilisateurRepository();
$userVerif=$rep->getUtilisateurParEmail($_POST["email"]);
if($userVerif!=null){
    header("Location: inscription.php?erreur=email");
    exit;
}else{

if(isset($_POST['type'])){
    switch ($_POST['type']) {
        case 'etudiant':
            require_once "../src/model/Etudiant.php";
            require_once "../src/repository/EtudiantRepository.php";
            require_once "../src/traitement/newEtudiant.php";

            if (isset($etudiant)){
                var_dump($_POST["cv_etudiant"]);
                $rep = new EtudiantRepository();
                $rep -> ajouterEtudiant($etudiant);
                header("Location: connexion.php");
                exit();
            }
            break;

        case 'alumni':
            require_once "../src/model/Alumni.php";
            require_once "../src/repository/AlumniRepository.php";
            require_once "../src/traitement/newAlumni.php";

            if (isset($alumni)){

                $rep = new AlumniRepository();
                $rep -> ajouterAlumni($alumni);
                header("Location: connexion.php");
                exit();
            }
            break;


        case 'professeur':
            require_once "../src/model/Professeur.php";
            require_once "../src/repository/ProfesseurRepository.php";
            require_once "../src/model/ProfesseurFormation.php";
            require_once "../src/repository/ProfesseurFormationRepository.php";
            require_once "../src/traitement/newProfesseur.php";

            if (isset($professeur)){
                $rep = new ProfesseurRepository();
                $rep2 = new ProfesseurFormationRepository();

                $lastId = $rep -> ajouterProfesseur($professeur);
                if(isset($_POST["formations"])){
                foreach($_POST["formations"] as $formation){
                    $professeurFormation = new professeurFormation(null,$lastId,$formation);
                    $rep2->ajouterProfesseurFormations($professeurFormation);
                }}
                header("Location: connexion.php");
                exit();
            }
            break;


        case 'partenaire':
            require_once "../src/model/Partenaire.php";
            require_once "../src/repository/PartenaireRepository.php";
            require_once "../src/traitement/newPartenaire.php";

            if (isset($partenaire)){
                $rep = new PartenaireRepository();
                $rep -> ajouterPartenaire($partenaire);
                header("Location: connexion.php");
                exit();
            }
            break;
    }
}}



