<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');



if (isset($_SESSION['mdp'])) {
    $recupFavorisP = $bdd->prepare('SELECT * FROM favoris WHERE user = ?');
    $recupFavorisP->execute(array($_SESSION['id']));
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Leaflet</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/pageFavoris.css">
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
                    <a class="link" href="decouvrir.php">Découvrir</a>
                    <?php
                    if (isset($_SESSION['mdp'])) {
                    ?>
                        <a class="link" href="#">Favoris</a>
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

        <H1>VOS FAVORIS</H1>
        <div class="favoris-list">
            <?php
            while ($fetch = $recupFavorisP->fetch()) {
            ?>

                <div class="favoris-list-item">
                    <div class="favoris-list-item-left">
                        <div class="favoris-list-item-description">
                            <p class="favoris-list-item-description-text">Voie</p>
                            <td><?php echo str_replace("_", " ", $fetch['voie']) ?></td>
                        </div>
                        <div class="favoris-list-item-description">
                            <p class="favoris-list-item-description-text">Type</p>
                            <td><?php echo str_replace("_", " ", $fetch['type_fontaine']) ?></td>
                        </div>
                        <div class="favoris-list-item-description">
                            <p class="favoris-list-item-description-text">Latitude</p>
                            <td><?php echo $fetch['lat'] ?></td>
                        </div>
                        <div class="favoris-list-item-description">
                            <p class="favoris-list-item-description-text">Longitude</p>
                            <td><?php echo $fetch['lng'] ?></td>
                        </div>
                    </div>
                    <p class="delete-btn" onclick="handleDelete(<?php echo $fetch['lat']; ?>, <?php echo $fetch['lng']; ?>)">Supprimer des favoris</p>
                </div>

            <?php
            }
            ?>
        </div>
        <script src="header.js"></script>
        <script>
            function handleDelete(lat, lng) {
                console.log(lat, lng);
                $.ajax({
                    type: 'POST',
                    url: 'favoris.php',
                    data: {
                        'lat': lat,
                        'lng': lng,
                        'enregistré': true
                    },
                    success: function(res) {
                        console.log(res);
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
                document.location.reload();
            }
        </script>

</body>

</html>