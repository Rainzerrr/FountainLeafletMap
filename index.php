<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');
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
                <a href="#"><img id="logo" src="assets/logo.png"></a>
                <div class="rubriques">
                    <a class="link" href="#">Accueil</a>
                    <a class="link" href="#">Favoris</a>
                    <a class="link" href="#">Signaler</a>
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

        <div id="map"></div>

        <i class="filter-btn fa-solid fa-filter fa-2x"></i>

        <div id="side-panel">
            <p>Arrondissements</p>
            <div id="arrdt-container">
                <button class="btn hover-style arrdt-filter" value="1">1</button>
                <button class="btn hover-style arrdt-filter" value="2">2</button>
                <button class="btn hover-style arrdt-filter" value="3">3</button>
                <button class="btn hover-style arrdt-filter" value="4">4</button>
                <button class="btn hover-style arrdt-filter" value="5">5</button>
                <button class="btn hover-style arrdt-filter" value="6">6</button>
                <button class="btn hover-style arrdt-filter" value="7">7</button>
                <button class="btn hover-style arrdt-filter" value="8">8</button>
                <button class="btn hover-style arrdt-filter" value="9">9</button>
                <button class="btn hover-style arrdt-filter" value="10">10</button>
                <button class="btn hover-style arrdt-filter" value="11">11</button>
                <button class="btn hover-style arrdt-filter" value="12">12</button>
                <button class="btn hover-style arrdt-filter" value="13">13</button>
                <button class="btn hover-style arrdt-filter" value="14">14</button>
                <button class="btn hover-style arrdt-filter" value="15">15</button>
                <button class="btn hover-style arrdt-filter" value="16">16</button>
                <button class="btn hover-style arrdt-filter" value="17">17</button>
                <button class="btn hover-style arrdt-filter" value="18">18</button>
                <button class="btn hover-style arrdt-filter" value="19">19</button>
                <button class="btn hover-style arrdt-filter" value="20">20</button>
            </div>

            <p>Disponibilité (Optionnel)</p>
            <div class="dispo-container">
                <button class="btn hover-style dispo-filter" value="NON">Dispo</button>
                <button class="btn hover-style dispo-filter" value="OUI">Pas Dispo</button>
            </div>

            <button class="solo-btn hover-style submit-filter">Appliquer les filtres</button>
            <button class="solo-btn hover-style reinitialiser">Reinitialiser</button>
        </div>

    </div>
    <footer></footer>


    <script src="app.js"></script>
    <script src="header.js"></script>
    <script src="dist/leaflet.markercluster.js"></script>
</body>

</html>