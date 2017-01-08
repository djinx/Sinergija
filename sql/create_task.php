<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/29/2016
 * Time: 1:09 PM
 */

require_once('Database.php');

$db = Database::getInstance();

/*
 * id projekta iz hidden polja
 * ukoliko je prazno to znaci da se obaveza ne dodaje projektu
 * vec je nezavisna
*/
$projekat = $_POST['IdProjektaObaveza'];

//provera naziva
if(!empty($_POST['NazivObaveze'])){
    $naziv = $db->real_escape_string(trim($_POST['NazivObaveze']));
}else{
    $errors[] = "Molimo unesite naziv obaveze!";
}

//provera opisa
if(!empty($_POST['OpisObaveze'])){
    $opis = $db->real_escape_string(trim($_POST['OpisObaveze']));
}else{
    $errors[] = "Molimo unesite opis obaveze!";
}

$datum = $_POST['DatumPocetkaObaveze'];
$deadline = $_POST['Deadline'];
$tim = $_POST['Tim'];
$korisnik = $_POST['Korisnik'];
$datum1 =  date('Y-m-d', strtotime($datum));
$deadline1 =  date('Y-m-d', strtotime($deadline));

//pravljenje nove obaveze
$query =
    ' INSERT INTO obaveza(`idObaveze`, `Naziv`, `Opis`, `Datum_pocetka`, `Deadline`, `Odradjena`, `idTima`, `idProjekta`) 
      VALUES(NULL, ?, ?, ?, ?, 0, ?, ';
if($projekat == ""){
    // obaveza je nezavisna i za idProjekta unosimo NULL
    $query .= 'NULL)';
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("ssssi", $naziv, $opis, $datum1, $deadline1, $tim);
}
else{
    // obaveza se unosi u okviru projekta i unosi se idProjekta
    $query .= '?)';
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("ssssii", $naziv, $opis, $datum1, $deadline1, $tim, $projekat);
}
$preparedQuery->execute();
$preparedQuery->close();

//izdvajanje obaveze sa najvecim idObaveze - to je obaveza koja je poslednja uneta
$query = 'SELECT max(idObaveze) FROM obaveza';
$preparedQuery = $db->prepare($query);
if($preparedQuery->execute()) {
    $preparedQuery->bind_result($idObaveze);
    $preparedQuery->fetch();
}

$preparedQuery->close();

//dodavanje obaveze odabranom korisniku
$query = 'INSERT INTO `ima obavezu`(`idKorisnika`, `idObaveze`) VALUES (?, ?)';
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("ii", $korisnik, $idObaveze);
$preparedQuery->execute();
$preparedQuery->close();

header("Location: ../public/");

