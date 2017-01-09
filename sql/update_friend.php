<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/8/2017
 * Time: 9:48 PM
 */


require_once('Database.php');

$db = Database::getInstance();


$id = $_POST['Prijatelj'];

//provera broja
if(!empty($_POST['BrojTelefonaPrijatelja1'])){
    $broj = $db->real_escape_string(trim($_POST['BrojTelefonaPrijatelja1']));
}else{
    $broj = NULL;
}

//provera emaila
if(!empty($_POST['EmailPrijatelja1'])){
    $email = $db->real_escape_string(trim($_POST['EmailPrijatelja1']));
}else{
    $email = NULL;
}


//provera veb sajta
if(!empty($_POST['VebSajtPrijatelja1'])){
    $veb = $db->real_escape_string(trim($_POST['VebSajtPrijatelja1']));
}else{
    $veb = NULL;
}

if(!empty($_POST['ImeKontaktaPrijatelja1'])){
    $kontakt = $db->real_escape_string(trim($_POST['ImeKontaktaPrijatelja1']));
}else{
    $kontakt = NULL;
}

// provera adrese
if(!empty($_POST['AdresaPrijatelja1'])){
    $adresa = $db->real_escape_string(trim($_POST['AdresaPrijatelja1']));
}else{
    $adresa = NULL;
}

// unos novog prijatelja
$query =
    " UPDATE `prijatelji`
      SET `Broj_telefona` = ?, `Email` = ?, `Veb_sajt` = ?, `Ime_kontakta` = ?, `Adresa` = ? 
      WHERE `idPrijatelja` = ?";

$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("sssssi", $broj, $email,  $veb, $kontakt, $adresa, $id);

$preparedQuery->execute();
$preparedQuery->close();

header("Location: ../public/");