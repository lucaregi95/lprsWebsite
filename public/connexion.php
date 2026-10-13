<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$bdd = null;
require_once('bdd/bdd.php');

$nom=null;
$prenom=null;
$email=null;
if(isset($_POST['email'])){
    $email=$_POST['email'];
}
$erreur=null;
$inscription=null;
if(isset($_GET['erreur'])){
    if ($_GET['erreur']=='unknown'){
        $erreur="Identifiants inexistants ou incorrects";
    }

}

if(isset($_GET['page'])){
    $page=$_GET['page'];

}
$inscription="Pas de compte ? Inscrivez-vous";
?>
<!DOCTYPE html>

<html lang=fr>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>
<div ontainer mt-3 mb-3">
<div>
    <h1>Connectez-vous à votre compte LPRS</h1>
</div>

<div>
    <div>
        <div>
            <form method="POST" action="connexion2.php">
                <label for="email">Adresse e-mail :</label><br>
                <input type="email" id="email" name="email" value="<?=$email?>" autocomplete="off" required><br><br>

                <label for="mdp">Mot de Passe :</label><br>
                <input type="password" id="mdp" name="mdp" autocomplete="off" required><br>

                <?php if (isset($page)) {?>
                    <input type="hidden" value="<?=$page?>" name="page">
                <?php } ?>
                <h6><?=$erreur?></h6>

                <button type="submit">Connectez-vous !</button><br><br>
            </form>
            <div>
                <a href="inscription.php"><?=$inscription?></a>
            </div>
        </div>
    </div>
</div>
</div>
<footer>
    <div>
        <div>
            <h4>Nous contacter</h4>

            <a href="https://mail.google.com/mail/?view=cm&to=LPRS@gmail.com&su=Prise de contact"
               target="_blank">LPRS@gmail.com</a>
        </div>
    </div>
    <div>
        <p>© 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn, William Lemaire — Tous droits réservés</p>
    </div>
</footer>
</body>
</html>

