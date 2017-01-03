<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/29/2016
 * Time: 1:09 PM
 */

require_once('Database.php');

$db = Database::getInstance();

$naziv = $_POST['NazivObaveze'];
$opis = $_POST['OpisObaveze'];
$datum = $_POST['DatumPocetkaObaveze'];
$deadline = $_POST['Deadline'];
$tim = $_POST['Tim'];
$korisnik = $_POST['Korisnik'];
$datum1 =  date('Y-m-d', strtotime($datum));
$deadline1 =  date('Y-m-d', strtotime($deadline));

//pravljenje nove obaveze
$sql = 'INSERT INTO obaveza(`idObaveze`, `Naziv`, `Opis`, `Datum_pocetka`, `Deadline`, `Odradjena`, `idTima`) VALUES(NULL, ?, ?, ?, ?, 0, ?)';
$preparedQuery = $db->prepare($sql);
$preparedQuery->bind_param("ssssi", $naziv, $opis, $datum1, $deadline1, $tim);
$preparedQuery->execute();
$preparedQuery->close();
//echo $naziv." ".$opis." ".$datum1." ".$deadline1." ".$tim;

//izdvajanje obaveze sa najvecim idObaveze - to je obaveza koja je poslednja uneta
$query = 'SELECT max(idObaveze) FROM obaveza';
$preparedQuery = $db->prepare($query);
if($preparedQuery->execute()) {
    $preparedQuery->bind_result($idObaveze);
    $preparedQuery->fetch();
}

$preparedQuery->close();

//dodavanje obaveze odabranom korisniku
$sql = 'INSERT INTO `ima obavezu`(`idKorisnika`, `idObaveze`) VALUES (?, ?)';
$preparedQuery = $db->prepare($sql);
$preparedQuery->bind_param("ii", $korisnik, $idObaveze);
$preparedQuery->execute();
$preparedQuery->close();
//echo $korisnik." ".$row[0];

header("Location: ../public/");

