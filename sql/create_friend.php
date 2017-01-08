<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/8/2017
 * Time: 2:15 PM
 */

require_once('Database.php');

$db = Database::getInstance();

//provera naziva
if(!empty($_POST['NazivPrijatelja'])){
    $naziv = $db->real_escape_string(trim($_POST['NazivPrijatelja']));
}else{
    $errors[] = "Molimo unesite naziv prijatelja!";
}

//provera tipa
if(!empty($_POST['TipPrijatelja'])){
    $tip = $db->real_escape_string(trim($_POST['TipPrijatelja']));
}else{
    $errors[] = "Molimo unesite tip prijatelja!";
}

//provera podtipa
if(!empty($_POST['PodtipPrijatelja'])){
    $podtip = $db->real_escape_string(trim($_POST['PodtipPrijatelja']));
}else{
    $errors[] = "Molimo unesite podtip prijatelja!";
}

//provera broja
if(!empty($_POST['BrojTelefonaPrijatelja'])){
    $broj = $db->real_escape_string(trim($_POST['BrojTelefonaPrijatelja']));
}else{
    $broj = NULL;
}

//provera emaila
if(!empty($_POST['EmailPrijatelja'])){
    $email = $db->real_escape_string(trim($_POST['EmailPrijatelja']));
}else{
    $email = NULL;
}


//provera veb sajta
if(!empty($_POST['VebSajtPrijatelja'])){
    $veb = $db->real_escape_string(trim($_POST['VebSajtPrijatelja']));
}else{
    $veb = NULL;
}

if(!empty($_POST['ImeKontaktaPrijatelja'])){
    $kontakt = $db->real_escape_string(trim($_POST['ImeKontaktaPrijatelja']));
}else{
    $kontakt = NULL;
}

// provera adrese
if(!empty($_POST['AdresaPrijatelja'])){
    $adresa = $db->real_escape_string(trim($_POST['AdresaPrijatelja']));
}else{
    $adresa = NULL;
}

// unos novog prijatelja
$query =
    ' INSERT INTO `prijatelji`(`idPrijatelja`, `Naziv`, `Tip`, `Podtip`, `Broj_telefona`, `Email`, `Veb_sajt`, `Ime_kontakta`, `Adresa`) 
      VALUES (NULL, ?, ?, ? ,?, ?, ?, ? ,?)';

$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("ssssssss", $naziv, $tip, $podtip, $broj, $email,  $veb, $kontakt, $adresa);

$preparedQuery->execute();
$preparedQuery->close();

header("Location: ../public/");