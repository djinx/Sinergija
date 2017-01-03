<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/2/2017
 * Time: 3:19 PM
 */


require_once('Database.php');

$db = Database::getInstance();

$errors = array();

$projekat = $_POST['ProjekatIdP'];
$prijatelj = $_POST['Prijatelj'];
$zaduzen = $_POST['Zaduzen'];
$status = $_POST['Status'];

//provera napomene
if(!empty($_POST['Napomena'])){
    $napomena = $db->real_escape_string(trim($_POST['Napomena']));
}else{
    $napomena = NULL;
}

//upis podataka iz forme u bazu
if($napomena){
    $query =
        " INSERT INTO `zaduzen`(`idKorisnika`, `idProjekta`, `idSponzora`, `Status`, `Napomena`) 
          VALUES (?, ?, ?, ?, ?)";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("sssss", $zaduzen, $projekat, $prijatelj, $status, $napomena);
} else{
    $query =
        " INSERT INTO `zaduzen`(`idKorisnika`, `idProjekta`, `idSponzora`, `Status`, `Napomena`) 
          VALUES (?, ?, ?, ?, NULL)";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("ssss", $zaduzen, $projekat, $prijatelj, $status);
}
$preparedQuery->execute();

header("Location: ../public/");