<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 15.1.2017
 * Time: 16:32
 */
session_start();

require_once ('Database.php');

$db = Database::getInstance();

$idKorisnika = intval($_SESSION['username']['idKorisnika']);
$idProjekta = intval($_POST['Projekat']);
$idPrijatelja = $db->real_escape_string($_POST['Prijatelj']);
$status = $db->real_escape_string($_POST['Status']);
$napomena = $db->real_escape_string($_POST['Napomena']);

$query =
    "UPDATE zaduzen 
      SET status = ?, napomena = ?
      WHERE idKorisnika = ?
        AND idProjekta = ?
        AND idSponzora = ?";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("ssiii", $status, $napomena, $idKorisnika, $idProjekta, $idPrijatelja);
if($preparedQuery->execute()){
    $preparedQuery->close();
    header('Location: ../public/');
}else{
    die("Postoji problem sa ispunjavanjem zahteva: ".$db->error);
}
