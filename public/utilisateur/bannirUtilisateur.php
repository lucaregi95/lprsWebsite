<?php
require_once __DIR__ . '/../../src/repository/UtilisateurRepository.php';
if(isset($_POST['role'])){
    switch ($_POST['role']) {
        case 'etudiant':
            if(isset($_POST['id_utilisateur'])){
                require_once "../../src/model/Etudiant.php";
                require_once "../../src/repository/EtudiantRepository.php";
                require_once "../../src/traitement/newEtudiant.php";
                $rep = new EtudiantRepository();
                $etudiant = $rep->getEtudiant($_POST["id_utilisateur"]);
                $etudiant->setStatutValidation("banni");
                $rep->modifierEtudiant($etudiant);
                header("Location: ../admin.php");
                exit();
            }
            break;
        case 'alumni':
            if(isset($_POST['id_utilisateur'])){
                require_once "../../src/model/Alumni.php";
                require_once "../../src/repository/AlumniRepository.php";
                require_once "../../src/traitement/newAlumni.php";
                $rep = new AlumniRepository();
                $alumni = $rep->getAlumni($_POST["id_utilisateur"]);
                $alumni->setStatutValidation("banni");
                $rep->modifierAlumni($alumni);
                header("Location: ../admin.php");
                exit();
            }
            break;
        case 'partenaire':
            if(isset($_POST['id_utilisateur'])){
                require_once "../../src/model/Partenaire.php";
                require_once "../../src/repository/PartenaireRepository.php";
                require_once "../../src/traitement/newPartenaire.php";
                $rep = new PartenaireRepository();
                $partenaire = $rep->getPartenaire($_POST["id_utilisateur"]);
                $partenaire->setStatutValidation("banni");
                $rep->modifierPartenaire($partenaire);
                header("Location: ../admin.php");
                exit();
            }
            break;
        case "professeur":
            if(isset($_POST['id_utilisateur'])){
                require_once "../../src/model/Professeur.php";
                require_once "../../src/repository/ProfesseurRepository.php";
                require_once "../../src/traitement/newProfesseur.php";
                $rep = new ProfesseurRepository();
                $professeur = $rep->getProfesseur($_POST["id_utilisateur"]);
                $professeur->setStatutValidation("banni");
                $rep->modifierProfesseur($professeur);
                header("Location: ../admin.php");
                exit();
            }
            break;
        case 'gestionnaire':
            if(isset($_POST['id_utilisateur'])){
                require_once "../../src/model/Gestionnaire.php";
                require_once "../../src/repository/GestionnaireRepository.php";
                require_once "../../src/traitement/newGestionnaire.php";
                $rep = new GestionnaireRepository();
                $gestionnaire = $rep->getGestionnaire($_POST["id_utilisateur"]);
                $gestionnaire->setStatutValidation("banni");
                $rep->modifierGestionnaire($gestionnaire);
                header("Location: ../gestionnaire.php");
                exit();
            }
            break;
    }

    }

?>