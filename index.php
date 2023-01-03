<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');
if (isset($_POST['lat'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    addFavoris($bdd, $_SESSION['id'], $lat, $lng);
}
function addFavoris($bdd, $user, $lat, $lng)
{
    if ($user != 0) {
        $insertFavoris = $bdd->prepare('INSERT INTO favoris(user, lat, lng)VALUES(?, ?, ?)');
        $insertFavoris->execute(array($user, $lat, $lng));
    } else {
        echo "connectez vous pour favoris !";
    }
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
                <a href="#"><img id="logo" src="assets/logo.png"></a>
                <div class="rubriques">

                    <a class="link" href="#">Accueil</a>
                    <a class="link" href="#">Découvrir</a>
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

        <div id="map"></div>

        <i class="filter-btn fa-solid fa-filter fa-2x"></i>
        <i class="add-btn fa-solid fa-map-pin fa-2x"></i>

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


    <script>
        var data;
        var filters = [
            [],
            []
        ]; // tableau des filtres, indice 0 : arrondissements, indice 1 : disponibilité (ALL,OUI,NON)
        $btn = $(".btn"); // tous les boutons
        $arrdts = $('.arrdt-filter'); // tous les boutons arrondissements
        $dispoFilters = $('.dispo-filter'); // deux boutons de disponibilité
        $submitFilter = $('.submit-filter'); // bouton confirmation des filtres
        $reinit = $('.reinitialiser'); // bouton rénitialiser
        $connexion = $('#connexion-btn'); // bouton navbar connexion
        $coForm = $('#co-form'); // formulaire de connexion apres click sur bouton connexion
        $rubriques = $('.rubriques') // rubriques du menu

        $sidePanel = $("#side-panel"); // panneau des filtres apres click sur bouton filtres
        $filterBtn = $('.filter-btn'); // bouton filtrer à droite de l'écran

        // Variable qui stock le design de la carte

        var OpenStreetMap_HOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
        });


        // Variable qui stock les attributs de la map (zoom, design, position initiale...)

        var map = L.map('map', {
            center: [48.861477, 2.343219],
            zoom: 13,
            layers: [OpenStreetMap_HOT],
            zoomControl: false
        });

        // Custom icon


        var Fontaine = L.Icon.extend({
            options: {
                iconSize: [45, 45],
                shadowSize: [50, 64],
                iconAnchor: [22, 94],
                popupAnchor: [-3, -76]
            }
        });

        var dispoFontaine = new Fontaine({
            iconUrl: 'assets/fountain.png'
        })

        var pasDispoFontaine = new Fontaine({
            iconUrl: 'assets/noFountain.png'
        })

        var favorisFontaine = new Fontaine({
            iconUrl: 'assets/favorisFountain.png'
        })


        // Déplacement des boutons de zoom et dézoom en bas a droite, par défaut en haut a gauche

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);


        // Click sur le bouton de filtres a droite, affiche ou retire le panneau de filtres

        $filterBtn.on("click", function() {
            if ($sidePanel.css("display") === 'flex') {
                $sidePanel.css("display", "none");
                $filterBtn.css("right", "40px");
            } else {
                $sidePanel.css("display", "flex");
                $filterBtn.css("right", "260px");
            }
        });

        // Click sur le bouton de connexion, affichage du formulaire de connexion

        $connexion.on("click", function() {
            if ($coForm.css("display") === 'flex') {
                $coForm.css("display", "none");
            } else {
                $coForm.css("display", "flex");
            }
        });


        // Lancement du site

        $(document).ready(async function() {
            await init()
        })


        // Affichage de tous les markers de fontaines dans la carte

        async function init() {
            await fetch("https://opendata.paris.fr/api/records/1.0/search/?dataset=fontaines-a-boire&q=&rows=10000&facet=type_objet&facet=modele&facet=commune&facet=dispo")
                .then(reponse => reponse.json())
                .then(reponse2 => data = reponse2);
            filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
            var markers = new L.MarkerClusterGroup({
                disableClusteringAtZoom: 16
            });
            for (let i = 0; i < data.records.length; i++) {
                let mk;
                let text = "Voie : " + data.records[i].fields.voie + "<br/> Type : " + data.records[i].fields.type_objet
                if (data.records[i].fields.dispo === "OUI") mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                    icon: dispoFontaine
                });
                else mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                    icon: pasDispoFontaine
                });

                if (data.records[i].fields.commune.includes("PARIS")) {
                    mk.bindPopup(text + "<br/><br/>" + `<button onclick=handleFavoris(${data.records[i].fields.geo_point_2d})>Favoris</button>` +
                        `<button onclick=handleSignaler(${data.records[i].fields.geo_point_2d})>Signaler</button>`);
                    markers.addLayer(mk);
                }
            }

            map.addLayer(markers);
        }

        // Envoie les données du marker favoris au serveur

        function handleFavoris(lat, lng) {
            var latlng = {};
            latlng.lat = lat;
            latlng.lng = lng;
            $.ajax({
                type: 'POST',
                url: 'favoris.php',
                data: latlng,
                success: function(res) {
                    console.log(res);
                },

                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Envoie les données du marker à signaler au serveur

        function handleSignaler(lat, lng) {
            var latlng = {};
            latlng.lat = lat;
            latlng.lng = lng;
            $.ajax({
                type: 'POST',
                url: 'signalements.php',
                data: latlng,
                success: function(res) {
                    console.log(res);
                },

                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Click sur chaque bouton des arrondissements, dès que cliqué numéro correspondant ajouté/retiré dans/de la liste des filtres indice 0

        $arrdts.on("click", function(e) {
            let n = parseInt($(this).val());
            if (filters[0].indexOf(n) === -1) {
                $(this).css("background-color", "rgb(180,180,180)");
                filters[0].push(n);
            } else {
                $(this).css("background-color", "rgb(230, 230, 230)");
                filtersCopy = filters[0].filter(arrt => arrt !== n);
                filters[0] = filtersCopy;
            }
        })

        // Click sur les boutons de disponibilité, dès que cliqué valeur correspondant ajouté/retiré dans/de la liste des filtres indice 1

        $dispoFilters.on("click", function() {
            let n = $(this).val()
            if (filters[1].length === 0) {
                $(this).css("background-color", "rgb(180,180,180)");
                filters[1].push(n);
            } else {
                if (filters[1][0] === n) {
                    filtersCopy = filters[1].filter(arrt => arrt !== n);
                    filters[1] = filtersCopy;
                    $(this).css("background-color", "rgb(230, 230, 230)");
                } else {
                    filters[1] = [n];
                    $dispoFilters.css("background-color", "rgb(230, 230, 230)");
                    $(this).css("background-color", "rgb(180,180,180)");
                }
            }
        })

        // Reinitialise la carte en mettant toutes les fontaines visible

        $reinit.click(async function() {
            map.remove();
            map = L.map('map', {
                center: [48.861477, 2.343219],
                zoom: 13,
                layers: [OpenStreetMap_HOT],
                zoomControl: false
            });

            L.control.zoom({
                position: 'bottomright'
            }).addTo(map);
            $btn.css("background-color", "rgb(230, 230, 230)");
            filters = [
                [],
                []
            ]
            await fetch("https://opendata.paris.fr/api/records/1.0/search/?dataset=fontaines-a-boire&q=&rows=10000&facet=type_objet&facet=modele&facet=commune&facet=dispo")
                .then(reponse => reponse.json())
                .then(reponse2 => data = reponse2);
            filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
            var markers = new L.MarkerClusterGroup({
                disableClusteringAtZoom: 16
            });
            for (let i = 0; i < data.records.length; i++) {
                let mk;
                let text = "Voie : " + data.records[i].fields.voie + "<br/> Type : " + data.records[i].fields.type_objet
                if (data.records[i].fields.dispo === "OUI") mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                    icon: dispoFontaine
                });
                else mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                    icon: pasDispoFontaine
                });

                if (data.records[i].fields.commune.includes("PARIS")) {
                    mk.bindPopup(text + "<br/><br/>" + `<button onclick=handleFavoris(${data.records[i].fields.geo_point_2d})>Favoris</button>` +
                        `<button onclick=handleSignaler(${data.records[i].fields.geo_point_2d})>Signaler</button>`);
                    markers.addLayer(mk);
                }
            }

            map.addLayer(markers);
        })


        // Collecte et affiche les données après click sur le bouton submit (Appliquer les filtres)

        $submitFilter.on("click", function() {
            dataCollect();
        });


        // Collecte les données et les affiche en fonction des filtres choisis par l'utilisateur

        async function dataCollect() {
            if (filters[0].length === 0) {
                alert("Il faut sélectionner au moins 1 arrondissement !\nReinitialiser pour afficher tous les markers.");
            } else {
                map.remove();
                map = L.map('map', {
                    center: [48.861477, 2.343219],
                    zoom: 13,
                    layers: [OpenStreetMap_HOT],
                    zoomControl: false
                });

                L.control.zoom({
                    position: 'bottomright'
                }).addTo(map);
                await fetch("https://opendata.paris.fr/api/records/1.0/search/?dataset=fontaines-a-boire&q=&rows=10000&facet=type_objet&facet=modele&facet=commune&facet=dispo")
                    .then(reponse => reponse.json())
                    .then(reponse2 => data = reponse2);
                let dispoFilter;
                filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
                mkGroupCluster = new L.MarkerClusterGroup({
                    disableClusteringAtZoom: 15
                });
                for (let i = 0; i < data.records.length; i++) {
                    let mk;
                    let text = "Voie : " + data.records[i].fields.voie + "<br/> Type : " + data.records[i].fields.type_objet
                    if (data.records[i].fields.dispo === "OUI") mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                        icon: dispoFontaine
                    });
                    else mk = L.marker([data.records[i].fields.geo_point_2d[0], data.records[i].fields.geo_point_2d[1]], {
                        icon: pasDispoFontaine
                    });
                    for (let j = 0; j < filters[0].length; j++) {
                        if (data.records[i].fields.commune.includes(`PARIS ${filters[0][j]}E`) && data.records[i].fields.dispo !== dispoFilter) {
                            mk.bindPopup(text + "<br/><br/>" + `<button onclick=handleFavoris(${data.records[i].fields.geo_point_2d})>Favoris</button>` +
                                `<button onclick=handleSignaler(${data.records[i].fields.geo_point_2d})>Signaler</button>`);
                            mkGroupCluster.addLayer(mk);
                        }
                    }
                }
                map.addLayer(mkGroupCluster);
            }

        }
    </script>
    <script src="header.js"></script>
    <script src="dist/leaflet.markercluster.js"></script>
</body>

</html>