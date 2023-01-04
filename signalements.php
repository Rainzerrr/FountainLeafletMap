<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $voie = $_POST['voie'];
    $type = $_POST['type'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $enregistré = filter_var($_POST['enregistré'], FILTER_VALIDATE_BOOLEAN);
    signalements($bdd, $_SESSION['id'], $voie, $type, $lat, $lng, $enregistré);
    header("Location : index.php");
}

$recupSignalement = $bdd->prepare('SELECT * FROM signalements');
$recupSignalement->execute(array());
$Signalement = $recupSignalement->fetchAll();
echo json_encode($Signalement);

function signalements($bdd, $user, $voie, $type, $lat, $lng, $enregistré)
{
    if (!$enregistré) {
        $changeSignalement = $bdd->prepare('INSERT INTO signalements(user, voie, type_fontaine, lat, lng)VALUES(?, ?, ?, ?, ?)');
        $changeSignalement->execute(array($user, $voie, $type, $lat, $lng));
    } else {
        $changeSignalement = $bdd->prepare('DELETE FROM signalements WHERE user = ? AND lat = ? AND lng = ?');
        $changeSignalement->execute(array($user, $lat, $lng));
    }
}
