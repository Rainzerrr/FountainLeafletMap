<?php
session_start();
$errorMsg = "";
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');
if (isset($_POST['submit_inscription'])) {
    if (!empty($_POST['pseudo_inscription']) and !empty($_POST['mdp_inscription'])) {
        $pseudoInscription = htmlspecialchars($_POST['pseudo_inscription']);
        $mdpInscription = sha1($_POST['mdp_inscription']);
        $insertUser = $bdd->prepare('INSERT INTO users(pseudo,mdp)VALUES(?, ?)');
        $insertUser->execute(array($pseudoInscription, $mdpInscription));

        $recupUserInscription = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUserInscription->execute(array($pseudoInscription, $mdpInscription));

        if ($recupUserInscription->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudoInscription;
            $_SESSION['mdp'] = $mdpInscription;
            $_SESSION['id'] = $recupUserInscription->fetch()['id'];
            header('Location: index.php');
        }
    }
}

if (isset($_POST['submit_connexion'])) {
    if (!empty($_POST['pseudo_connexion']) and !empty($_POST['mdp_connexion'])) {
        $pseudoConnexion = htmlspecialchars($_POST['pseudo_connexion']);
        $mdpConnexion = sha1($_POST['mdp_connexion']);

        $recupUserConnexion = $bdd->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUserConnexion->execute(array($pseudoConnexion, $mdpConnexion));

        if ($recupUserConnexion->rowCount() > 0) {
            $_SESSION['pseudo'] = $pseudoConnexion;
            $_SESSION['mdp'] = $mdpConnexion;
            $_SESSION['id'] = $recupUserConnexion->fetch()['id'];
            header('Location: index.php');
            $errorMsg = "";
        } else {
            $errorMsg = "Identifiant et/ou mot de passe incorrect";
        }
    }
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" type="text/css" href="css/ident.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <div id="left-container">
            <i class="fa-solid fa-bars fa-2xl hamb-menu"></i>
            <a href="index.php"><img id="logo" src="assets/logo.png"></a>
            <div class="rubriques">

                <a class="link" href="index.php">Accueil</a>
                <a class="link" href="decouvrir.php">Découvrir</a>
                <?php
                if (isset($_SESSION['mdp'])) {
                ?>
                    <a class="link" href="pageFavoris.php">Favoris</a>
                <?php

                } else {
                ?>
                    <a class="link" href="ident.php">Favoris</a>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['mdp'])) {
                ?>
                    <a class="link" href="pageSignalement.php">Signalements</a>
                <?php

                } else {
                ?>
                    <a class="link" href="ident.php">Signalements</a>
                <?php
                }
                ?>
                <a class="link" href="contact.php">Contact</a>
            </div>
        </div>

        <div style="display : flex; align-items : center;">
            <div class="icon">
                <i class="co fa-solid fa-user fa-xl"></i>
                <?php
                if (isset($_SESSION['mdp'])) {
                ?>
                    <a><?= $_SESSION['pseudo'] ?></a>
                <?php


                } else {
                ?>
                    <a>S'identifier</a>
                <?php
                }
                ?>
            </div>
            <?php
            if (isset($_SESSION['mdp'])) {
            ?>
                <a style="font-size : 1em; width: auto;" class="link" href="deconnexion.php">Deconnexion</a>
            <?php
            }
            ?>
        </div>

    </header>

    <div class="formulaires">
        <div class="container">
            <form method="post">
                <p class="form-title">Inscription</p>
                <div><img class="imglogin" src="assets/user.png"><input type="text" name="pseudo_inscription" placeholder="Nom d'utilisateur" required><br></div>
                <div><img class="imglogin" src="assets/mdp.png"><input type="password" name="mdp_inscription" placeholder="Mot de passe" required><br></div>
                <input type="submit" name="submit_inscription" value="S'inscrire">
            </form>
        </div>

        <div class="container">

            <form method="post">
                <p class="form-title">Connexion</p>
                <div><img class="imglogin" src="assets/user.png"><input type="text" name="pseudo_connexion" placeholder="Nom d'utilisateur" required><br></div>

                <div><img class="imglogin" src="assets/mdp.png"><input type="password" name="mdp_connexion" placeholder="Mot de passe" required><br></div>
                <input type="submit" name="submit_connexion" value="Connexion">
                <?php
                ?>
                <p style="color: red; font-size : 0.9em;" class="error-msg"> <?= $errorMsg; ?></p>
                <?php
                ?>
            </form>
        </div>
    </div>


    <script src="header.js"></script>
</body>

</html>