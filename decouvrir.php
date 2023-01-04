<?php

session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Découvrir</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/decouvrir.css">
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
                <a style="font-size : 1em; width: auto;" class="link" href="deconnexion.php">Déconnexion</a>
            <?php
            }
            ?>
        </div>



    </header>
    <div id="bg-img">
    </div>

    <h3>L’eau accessible à tout le monde</h3>
    <div class="text">

        <p>Crée en 2023, le site Eau de Paris est un service qui permet de <br>
            recenser toutes les fontaines à boire d’Ile de France. L’objectif de ce<br>
            service est de permettre aux plus grands nombres de personnes <br>
            d’avoir accès gratuitement à de l’eau potable, par le biais d’une carte <br>
            interactive qui regroupe l’ensemble de ces fontaines publiques.
        </p>
        <p>Eau de Paris en chiffres : <br>
            <strong>1052 fontaines </strong>à Paris et en Ile-de-France <br>
            <strong>483 000 m³</strong> d'eau potable distribué chaque jour <br>
            <strong>120 litres d’eau</strong> consommé en moyenne par personne <br>
            <strong>3 millions d’usagers </strong> <br>
        </p>
    </div>
    <div class="secondepart">
        <h3>Découvrez les différentes fontaines d’Ile de France !</h3>
        <img id="img-bg" src="assets/bg.jpg">
        <div class="fontaine">


            <p>La fontaine de Wallace, une fontaine en fonte de fer modéliser à la fin du 19ème siècle par Charles-Auguste Lebourg.</p>
            <p>La fontaine Arceau, du style moderne et épuré permet à une personne de boire debout sans risque d’éclaboussures.</p>
            <p>La fontaine du millénaire représentant deux silhouettes accolées dos à dos, telles des Vénus contemporaines.</p>
            <p>La fontaine à l’Albien d’une structure tubulaire métallique. Elles sont alimentées par des puits artésiens.</p>
            <p>La fontaine pétillante, comme son nom l’indique, distribue de l’eau pétillante.</p>

        </div>
    </div>

    <script src="header.js"></script>
</body>

</html>