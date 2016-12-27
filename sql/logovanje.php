<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.12.2016
 * Time: 16:48
 */
session_start();

require_once('Database.php');

$db = Database::getInstance();

if (isset($_POST['login-credentials'])) {

    $errors = array();

    // Provera da li su polja popunjena na strani servera
    if (empty($_POST['username'])) {
        $errors[] = "Please enter your username";
    } else {
        $username = $db->real_escape_string($_POST['username']);
    }

    if (empty($_POST['password'])) {
        $errors[] = "Please enter your password";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($errors)) {
        $sql = "select * from korisnik where nadimak = ?";
        $preparedQuery = $db->prepare($sql);
        $preparedQuery->bind_param("s", $username);
        $preparedQuery->bind_result(
            $idKorisnika, $Ime, $Prezime, $Telefon, $Email, $Slika, $Nadimak, $Sifra, $Tip
        );
        $preparedQuery->execute();
        $preparedQuery->fetch();

        /*if($preparedQuery->num_rows == 1){

        }else{
            $_SESSION['bad_password'] = true;
            header("Location:../public/");
        }*/
        if (password_verify($password, $Sifra)) {
            // Poklapaju se lozinke, sesija moze da pocne

            $_SESSION['username']['idKorisnika'] = $idKorisnika;
            $_SESSION['username']['Ime'] = $Ime;
            $_SESSION['username']['Prezime'] = $Prezime;
            $_SESSION['username']['Telefon'] = $Telefon;
            $_SESSION['username']['Email'] = $Email;
            $_SESSION['username']['Slika'] = $Slika;
            $_SESSION['username']['Nadimak'] = $Nadimak;
            $_SESSION['username']['Tip'] = $Tip;

            header("Location:../public/");
        } else {
            $_SESSION['bad_password'] = true;

            header("Location:../public/");
        }
    }
}