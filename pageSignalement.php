<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    addFavoris($bdd, $_SESSION['id'], $lat, $lng);
    header("Location : index.php");
}

if (isset($_SESSION['mdp'])) {
    $recupFavoris = $bdd->prepare('SELECT * FROM favoris WHERE user = ?');
    $recupFavoris->execute(array($_SESSION['id']));
    $favoris = $recupFavoris->fetchAll();
}

function addFavoris($bdd, $user, $lat, $lng)
{
    $insertFavoris = $bdd->prepare('INSERT INTO favoris(user, lat, lng)VALUES(?, ?, ?)');
    $insertFavoris->execute(array($user, $lat, $lng));
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Leaflet</title>
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="dist/MarkerCluster.css">
    <link rel="stylesheet" href="dist/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>

    <div id="content">
        <header>
            <div id="left-container">
                <i class="fa-solid fa-bars fa-2xl hamb-menu"></i>
                <a href="index.php"><img id="logo" src="assets/logo.png"></a>
                <div class="rubriques">

                    <a class="link" href="index.php">Accueil</a>
                    <a class="link" href="#">Découvrir</a>
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
                        <a class="link" href="#">Signalements</a>
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
                    <a style="font-size : 1em; width: auto;" class="link" href="deconnexion.php">Déconnexion</a>
                <?php
                }
                ?>
            </div>



        </header>
        <?php
        ?>
        <H2><?= $_SESSION['pseudo'] ?></h2>
        <?php
        ?>
        <H1>VOS SIGNALEMENTS</H1>
        <script src="header.js"></script>
</body>

</html>