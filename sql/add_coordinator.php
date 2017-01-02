<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/2/2017
 * Time: 1:26 PM
 */

require_once('Database.php');

$db = Database::getInstance();

$projekat = $_POST['ProjekatK'];
$korisnik = $_POST['Ucesnici'];

$query = "SELECT idTima FROM ucestvuje WHERE idKorisnika = ? AND idProjekta = ?";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("ii", $korisnik, $projekat);
$preparedQuery->execute();

$result = $preparedQuery->get_result();
if($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $tim = $row['idTima'];
}
else
    $tim = 2000;

$query = "INSERT INTO `koordinira`(`idProjekta`, `idKorisnika`, `idTima`) VALUES (?, ?, ?)";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("iii", $projekat, $korisnik , $tim);
$preparedQuery->execute();

header("Location: ../public/");