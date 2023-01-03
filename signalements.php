<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    addSignalements($bdd, $_SESSION['id'], $lat, $lng);
    header("Location : index.php");
}

$recupSignalement = $bdd->prepare('SELECT * FROM signalements');
$recupSignalement->execute(array());
$Signalement = $recupSignalement->fetchAll();
echo json_encode($Signalement);

function addSignalements($bdd, $user, $lat, $lng)
{
    $insertSignalement = $bdd->prepare('INSERT INTO signalements(user, lat, lng)VALUES(?, ?, ?)');
    $insertSignalement->execute(array($user, $lat, $lng));
}
