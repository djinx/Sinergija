<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/2/2017
 * Time: 11:16 AM
 */

require_once('Database.php');

$db = Database::getInstance();

$projekat = $_POST['Projekat'];
$korisnik = $_POST['Ucesnik'];
$tim = $_POST['TimUcesnika'];

$query = "INSERT INTO `ucestvuje` VALUES (?, ?, ?, NOW())";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("iii", $korisnik, $projekat, $tim);
$preparedQuery->execute();

header("Location: ../public/");
