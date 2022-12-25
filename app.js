var data;
var filters = [[],[]]; // tableau des filtres, indice 0 : arrondissements, indice 1 : disponibilité (ALL,OUI,NON)
$btn = $(".btn"); // tous les boutons
$arrdts = $('.arrdt-filter'); // tous les boutons arrondissements
$dispoFilters = $('.dispo-filter'); // deux boutons de disponibilité
$submitFilter = $('.submit-filter'); // bouton confirmation des filtres
$reinit = $('.reinitialiser'); // bouton rénitialiser
$connexion = $('#connexion-btn'); // bouton navbar connexion
$coForm = $('#co-form'); // formulaire de connexion apres click sur bouton connexion
$rubriques = $('.rubriques') // rubriques du menu

$sidePanel = $("#side-panel"); // panneau des filtres apres click sur bouton filtres
$filterBtn = $('.filter-btn');  // bouton filtrer à droite de l'écran

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

$filterBtn.on("click", function(){
    if($sidePanel.css("display") === 'flex'){
        $sidePanel.css("display","none");
        $filterBtn.css("right","30px");
    }   
    else{
        $sidePanel.css("display","flex");
        $filterBtn.css("right","260px");
    }
});

// Click sur le bouton de connexion, affichage du formulaire de connexion

$connexion.on("click", function(){
    if($coForm.css("display") === 'flex'){
        $coForm.css("display","none");
    }
    else{
        $coForm.css("display","flex");
    }
});


// Lancement du site

$(document).ready(async function(){
    await init()
})

// Affichage de tous les markers de fontaines dans la carte

async function init(){
    await fetch("/fontaines-a-boire.json")
    .then(reponse => reponse.json())
    .then(reponse2 => data = reponse2);
    filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
    var markers = new L.MarkerClusterGroup({disableClusteringAtZoom: 16});
    console.log(data[0])
    for(let i=0; i<data.length; i++){
        let mk;
        if (data[i].fields.dispo === "OUI") mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: dispoFontaine });
        else mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: pasDispoFontaine });
        
        if(data[i].fields.commune.includes("PARIS")){
            markers.addLayer(mk);
        }
    }

    map.addLayer(markers);
}

// Click sur chaque bouton des arrondissements, dès que cliqué numéro correspondant ajouté/retiré dans/de la liste des filtres indice 0

$arrdts.on("click",function(e){
    let n = parseInt($(this).val());
    if(filters[0].indexOf(n) === -1){
        $(this).css("background-color", "rgb(180,180,180)");
        filters[0].push(n);
    }
    else{
        $(this).css("background-color", "rgb(230, 230, 230)");
        filtersCopy = filters[0].filter(arrt => arrt !== n);
        filters[0] = filtersCopy;
    }
})

// Click sur les boutons de disponibilité, dès que cliqué valeur correspondant ajouté/retiré dans/de la liste des filtres indice 1

$dispoFilters.on("click",function(){
    let n = $(this).val()
    if(filters[1].length === 0){
        $(this).css("background-color", "rgb(180,180,180)");
        filters[1].push(n);
    }
    else{
        if(filters[1][0] === n){
            filtersCopy = filters[1].filter(arrt => arrt !== n);
            filters[1] = filtersCopy;
            $(this).css("background-color", "rgb(230, 230, 230)");
        }
        else{
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
        zoomControl : false
    });
    
    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);
    $btn.css("background-color","rgb(230, 230, 230)");
    filters = [[],[]]
    await fetch("/fontaines-a-boire.json")
    .then(reponse => reponse.json())
    .then(reponse2 => data = reponse2);
    filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
    var markers = new L.MarkerClusterGroup({disableClusteringAtZoom: 16});
    for(let i=0; i<data.length; i++){
        let mk;
        if (data[i].fields.dispo === "OUI") mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: dispoFontaine });
        else mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: pasDispoFontaine });
        if(data[i].fields.commune.includes("PARIS")){
            markers.addLayer(mk);
        }
    }

    map.addLayer(markers);
})


// Collecte et affiche les données après click sur le bouton submit (Appliquer les filtres)

$submitFilter.on("click", function() {
    dataCollect();} 
);


// Collecte les données et les affiche en fonction des filtres choisis par l'utilisateur

async function dataCollect(){
    if(filters[0].length === 0){
        alert("Il faut sélectionner au moins 1 arrondissement !");
    }

    else{
        map.remove();
        map = L.map('map', {
        center: [48.861477, 2.343219],
        zoom: 13,
        layers: [OpenStreetMap_HOT],
        zoomControl : false
    });
    
    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);
    await fetch("/fontaines-a-boire.json")
    .then(reponse => reponse.json())
    .then(reponse2 => data = reponse2);
    let dispoFilter;
    filters[1].length === 1 ? dispoFilter = filters[1][0] : dispoFilter = "ALL";
    mkGroupCluster = new L.MarkerClusterGroup({disableClusteringAtZoom: 15});
    for(let i=0; i<data.length; i++){
        let mk;
        if (data[i].fields.dispo === "OUI") mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: dispoFontaine });
        else mk = L.marker([data[i].fields.geo_point_2d[0], data[i].fields.geo_point_2d[1]], { icon: pasDispoFontaine });
        for(let j=0; j<filters[0].length; j++){
            if(data[i].fields.commune.includes(`PARIS ${filters[0][j]}E`) && data[i].fields.dispo !== dispoFilter){
                mkGroupCluster.addLayer(mk);
            }
        }
    }
    map.addLayer(mkGroupCluster);
    }  
    
}














































































































































































































// var data;
// const NB_ARRONDISSEMENTS = 20;
// var markers_arrts = [];
// $btn = $('.btn');
// $reinit = $('#reinitialiser');

// // var redIcon = L.icon({
// //     iconUrl: '/assets/redPin.png',

// //     iconSize:     [38, 38], // size of the icon
// //     iconAnchor:   [22, 22], // point of the icon which will correspond to marker's location
// //     popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
// // });

// // var blueIcon = L.icon({
// //     iconUrl: '/assets/bluePin.png',

// //     iconSize:     [85, 40], // size of the icon
// //     iconAnchor:   [22, 22], // point of the icon which will correspond to marker's location
// //     popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
// // });

// // for(let i=0; i<NB_ARRONDISSEMENTS; i++){
// //     markers_arrts.push([[],false]);
// // }




// // $( document ).ready(async function() {

// //     await init();

// //     $btn.on("click", function() {
// //         let i = parseInt($(this).val());
// //         if(!markers_arrts[i-1][1]){
// //             handlePrint(i);
// //             $(this).css("background-color","rgb(200,200,200)")
// //             markers_arrts[i-1][1] = true;
// //         }
// //         else{
// //             handleDelete(i);
// //             $(this).css("background-color","white")
// //             markers_arrts[i-1][1] = false;
// //         }
        
// //     });



// //     var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
// //     maxZoom: 19,
// //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// // })

// //     var map = L.map('map', {
// //         center: [48.861477, 2.343219],
// //         zoom: 13,
// //         layers: [osm]
// //     });

// //     L.marker([50.845651,2.28794895161], {icon: redIcon}).addTo(map);
// //     L.marker([50.840651,2.28794895161], {icon: blueIcon}).addTo(map);
// //     var layers = [];

// //     for (let i=0; i<NB_ARRONDISSEMENTS; i++){
// //         layers.push(L.layerGroup(markers_arrts[i][0]))
// //     }

// //    function handlePrint(i){
// //         layers[i-1].addTo(map);
// //     }

// //     function handleDelete(i){
// //         map.removeLayer(layers[i-1]);
// //     }

//     $reinit.click(() => {
//         map.remove();
//         map = L.map('map', {
//             center: [48.861477, 2.343219],
//             zoom: 13,
//             layers: [osm]
//         });
//         for(let i=0; i<NB_ARRONDISSEMENTS; i++){
//            markers_arrts[i][1] = false; 
//         }
//         $btn.css("background-color","white");
// })});






// // async function init() {

    


// //     await fetch("/fontaines-a-boire.json")
// //     .then(reponse => reponse.json())
// //     .then(reponse2 => data = reponse2);
// //     for (let i=0; i<data.length; i++){
// //         let d = data;
// //         if(d[i].fields.commune.includes("PARIS 1ER ARRONDISSEMENT")){
// //             let mk = L.marker([d[i].fields.geo_point_2d[0], d[i].fields.geo_point_2d[1]]);
// //             markers_arrts[0][0].push(mk);
// //         }  
// //         if(d[i].fields.commune.includes("PARIS 2EME ARRONDISSEMENT")){
// //             let mk = L.marker([d[i].fields.geo_point_2d[0], d[i].fields.geo_point_2d[1]]);
// //             markers_arrts[1][0].push(mk);
// //         }
// //     }

// // }