<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    addFavoris($bdd, $_SESSION['id'], $lat, $lng);
    header("Location : index.php");
}

function addFavoris($bdd, $user, $lat, $lng)
{
    $insertFavoris = $bdd->prepare('INSERT INTO favoris(user, lat, lng)VALUES(?, ?, ?)');
    $insertFavoris->execute(array($user, $lat, $lng));
}
