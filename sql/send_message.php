<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/12/2017
 * Time: 11:22 PM
 */

session_start();

require_once('Database.php');

$db = Database::getInstance();

 if (isset($_POST['posaljiPoruku']))
 {
// ako je korisnik podneo formu, upisujemo sadržaj u bazu
     if(!empty($_POST['idPrimaoca'])){
         $idPrimaoca = intval($_POST['idPrimaoca']);
     }
     else{
         $idPrimaoca = null;
     }

     $posiljaoc = $_SESSION['username']['idKorisnika'];

     if(!empty($_POST['tekstPoruke'])) {
         $poruka = $db->real_escape_string(trim($_POST['tekstPoruke']));
     }else{
         $poruka = "";
     }

     if(!empty($_POST['naslovPoruke'])) {
         $naslov = $db->real_escape_string(trim($_POST['naslovPoruke']));
     }else{
         $naslov = "Nenaslovljena poruka";
     }

     $query = "INSERT INTO `privatna poruka` (idPoruke, idPosiljaoca, idPrimaoca, poruka, naslov, datum, procitana) VALUES (null,?, ?, ?, ?, NOW(), false)";
     $preparedQuery = $db->prepare($query);
     $preparedQuery->bind_param("iiss", $posiljaoc, $idPrimaoca, $poruka, $naslov);

     $preparedQuery->execute();
     $preparedQuery->close();
 }

//header("Location: ../public/");