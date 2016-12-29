<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 29.12.2016
 * Time: 16:20
 */
require_once ('Database.php');

$db = Database::getInstance();

if(isset($_POST["noviClan"])){
    $errors = array();

    // provera imena
    if(!empty($_POST["ImeClana"])){
        $ime = $db->real_escape_string(trim($_POST["ImeClana"]));
    }else{
        $errors[] = "Molimo unesite ime novog člana!";
    }

    // provera prezimena
    if(!empty($_POST["PrezimeClana"])){
        $prezime = $db->real_escape_string(trim($_POST["PrezimeClana"]));
    }else{
        $errors[] = "Molimo unesite prezime novog člana!";
    }

    // provera broja telefona
    if(!empty($_POST["BrojTelefonaClana"])){
        $brojTelefona = $db->real_escape_string(trim($_POST["BrojTelefonaClana"]));
    }else{
        $errors[] = "Molimo unesite broj telefona novog člana!";
    }

    // provera nadimka
    if(!empty($_POST["NadimakClana"])){
        $nadimak = $db->real_escape_string(trim($_POST["NadimakClana"]));
    }else{
        $errors[] = "Molimo unesite nadimak novog člana!";
    }

    // provera email-a
    if(!empty($_POST["EmailClana"])){
        $email = $db->real_escape_string(trim($_POST["EmailClana"]));
    }else{
        $errors[] = "Molimo unesite e-mail novog člana!";
    }

    // provera lozinke
    $lozinka = null;
    if(!empty($_POST["password"])){
        $lozinka = $db->real_escape_string(trim($_POST["password"]));
    }else{
        $errors[] = "Molimo unesite lozinku novog člana!";
    }

    // provera ponovljene lozinke
    if(!empty($_POST["passwordAgain"])){
        $lozinkaPonovo = $db->real_escape_string(trim($_POST["passwordAgain"]));
        if($lozinka != $lozinkaPonovo){
            $errors[] = "Lozinke se ne poklapaju!";
        }
    }else{
        $errors[] = "Molimo ponovite lozinku novog člana!";
    }

    // provera tipa korisnika
    if(!empty($_POST["tipClana"])){
        $tip = $db->real_escape_string(trim($_POST["tipClana"]));
        if(!($tip == 'c' || $tip == 'u')){
            $errors[] = "Odabrali ste nepodržani tip korisnika!";
        }
    }else{
        $errors[] = "Molimo odaberite tip novog člana!";
    }

    if(empty($errors)){
        // provera da li vec postoji korisnik sa zadatim nadimkom
        $query1 = "SELECT idKorisnika FROM Korisnik WHERE Nadimak = ?;";
        $preparedQuery1 = $db->prepare($query1);
        $preparedQuery1->bind_param("s", $nadimak);
        $preparedQuery1->execute();
        $num1 = $preparedQuery1->get_result()->num_rows;
        if($num1 != 0){
            die("Već postoji korisnik sa zadatim nadimkom");
        }
        $preparedQuery1->close();

        // upis novog korisnika u bazu
        $query2 = "INSERT INTO Korisnik(Ime, Prezime, Telefon, `E-mail`, Nadimak, Sifra, Tip) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $preparedQuery2 = $db->prepare($query2);
        if($preparedQuery2){
            $lozinka = password_hash($lozinka, PASSWORD_BCRYPT);
            $preparedQuery2->bind_param("sssssss", $ime, $prezime, $brojTelefona, $email, $nadimak, $lozinka, $tip);
            $preparedQuery2->execute();

            header("Location: ../public/");
        }else{
            die(var_dump($db->error));
        }
    }else{
        die(implode("<br>", $errors));
    }
}else{
    die("Greska u slanju podataka!");
}
