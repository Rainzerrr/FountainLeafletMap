<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membres;charset=utf8;', 'root', '');

if (isset($_SESSION['mdp']) and isset($_POST['lat'])) {
    $voie = $_POST['voie'];
    $type = $_POST['type'];
    $latU = $_POST['lat'];
    $lngU = $_POST['lng'];
    $enregistréU = filter_var($_POST['enregistré'], FILTER_VALIDATE_BOOLEAN);
    signalements($bdd, $_SESSION['id'], $voie, $type, $latU, $lngU, $enregistréU);
    header("Location : index.php");
}

$recupSignalementU = $bdd->prepare('SELECT * FROM signalements WHERE user = ?');
$recupSignalementU->execute(array($_SESSION['id']));
$SignalementU = $recupSignalementU->fetchAll();
echo json_encode($SignalementU);
