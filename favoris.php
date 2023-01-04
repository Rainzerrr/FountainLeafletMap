<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $voie = $_POST['voie'];
    $type = $_POST['type'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $enregistré = filter_var($_POST['enregistré'], FILTER_VALIDATE_BOOLEAN);
    favoris($bdd, $_SESSION['id'], $voie, $type, $lat, $lng, $enregistré);
    header("Location : index.php");
}

if (isset($_SESSION['mdp'])) {
    $recupFavoris = $bdd->prepare('SELECT * FROM favoris WHERE user = ?');
    $recupFavoris->execute(array($_SESSION['id']));
    $favoris = $recupFavoris->fetchAll();

    echo json_encode($favoris);
}

function favoris($bdd, $user, $voie, $type, $lat, $lng, $enregistré)
{
    if (!$enregistré) {
        $changeFavoris = $bdd->prepare('INSERT INTO favoris(user, voie, type_fontaine, lat, lng)VALUES(?, ?, ?, ?, ?)');
        $changeFavoris->execute(array($user, $voie, $type, $lat, $lng));
    } else {
        $changeFavoris = $bdd->prepare('DELETE FROM favoris WHERE user = ? AND lat = ? AND lng = ?');
        $changeFavoris->execute(array($user, $lat, $lng));
    }
}
