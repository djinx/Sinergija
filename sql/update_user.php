<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/18/2017
 * Time: 4:06 PM
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_POST['izmeniClana'])){
    $errors = array();

    $id = $_SESSION['username']['idKorisnika'];

    // provera broja telefona
    if(!empty($_POST["BrojTelefonaClana1"])){
        $brojTelefona = $db->real_escape_string(trim($_POST["BrojTelefonaClana1"]));
    }else{
        $errors[] = "Molimo unesite broj telefona člana!";
    }

    // provera nadimka
    if(!empty($_POST["NadimakClana1"])){
        $nadimak = $db->real_escape_string(trim($_POST["NadimakClana1"]));
    }else{
        $errors[] = "Molimo unesite nadimak člana!";
    }

    // provera email-a
    if(!empty($_POST["EmailClana1"])){
        $email = $db->real_escape_string(trim($_POST["EmailClana1"]));
    }else{
        $errors[] = "Molimo unesite e-mail člana!";
    }

    if(empty($errors)){
        $query =
            " UPDATE `Korisnik`
              SET `Telefon` = ?, `E-mail` = ?, `Nadimak` = ?
              WHERE `idKorisnika` = ?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("sssi", $brojTelefona, $email, $nadimak, $id);
        $preparedQuery->execute();
        $_SESSION['username']['Telefon'] = $brojTelefona;
        $_SESSION['username']['Email'] = $email;
        $_SESSION['username']['Nadimak'] = $nadimak;
    }else{
        die(implode("<br>", $errors));
    }
}else{
    die("Greska u slanju podataka!");
}


header("Location: ../public/");