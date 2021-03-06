<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 18.1.2017
 * Time: 20:20
 */
session_start();

require_once ('Database.php');

$db = Database::getInstance();

$idKorisnika = intval($_SESSION['username']['idKorisnika']);
$errors = array();
$message = "";

// provera lozinke
$lozinka = null;
if(!empty($_POST["novaLozinka"])){
    $lozinka = $db->real_escape_string(trim($_POST["novaLozinka"]));
}else{
    $errors[] = "Molimo unesite lozinku!";
}

// provera ponovljene lozinke
if(!empty($_POST["novaLozinkaAgain"])){
    $lozinkaPonovo = $db->real_escape_string(trim($_POST["novaLozinkaAgain"]));
    if($lozinka != $lozinkaPonovo){
        $errors[] = "Lozinke se ne poklapaju!";
    }
}else{
    $errors[] = "Molimo ponovite lozinku!";
}

if(empty($errors)){
    $query = "UPDATE korisnik SET Sifra = ? WHERE idKorisnika = ?";
    if($preparedQuery = $db->prepare($query)){
        $lozinka = password_hash($lozinka, PASSWORD_BCRYPT);
        $preparedQuery->bind_param("si", $lozinka, $idKorisnika);
        if($preparedQuery->execute()){
            $message = "Lozinka je promenjena!";
        }else{
            $message = "Postoji problem sa promenom lozinke!";
            die(var_dump($db->error));
        }
    }else{
        $message = "Postoji problem sa ispunjenjem zahteva!";
        die(var_dump($db->error));
    }
}else{
    die(implode("; ", $errors));
}

header("Location: ../public/");