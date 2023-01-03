<?php

session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Page de contact</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="contact.css">
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
                <a class="link" href="#">Contact</a>
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
    <div class="form-container">

        <form method="post">
            <h3>Formulaire de contact</h3>
            <div class="formdiv">
                <label for="prenom">Prénom</label>
                <input type="text" class="formtxt" id="prenom" name="prenom" required>
            </div>
            <div class="formdiv">
                <label for="nom">Nom</label>
                <input type="text" class="formtxt" id="nom" name="nom" required>
            </div>
            <div class="formdiv">
                <label for="email">Email</label>
                <input type="email" class="formtxt" id="email" name="email" required>
            </div>
            <div class="formdiv">
                <label for="message">Message</label>
                <textarea class="formtxt" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn">Envoyer</button>
        </form>
    </div>

    <script src="header.js"></script>
</body>

</html>