<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1.1.2017
 * Time: 19:29
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();
$db->autocommit(true);

if(!(isset($_POST['akcija']) && isset($_POST['Korisnik']) && isset($_SESSION['username']['Tip']))&& isset($_SESSION['username']['idKorisnika']) && isset($_SESSION['username']['Ime']) && isset($_SESSION['username']['Prezime'])){
    exit();
}

$akcija = $_POST['akcija'];
$tip = $_SESSION['username']['Tip'];
$id = intval($_POST['Korisnik']);
$idOsobeKojaBrise = intval($_SESSION['username']['idKorisnika']);
$imeOsobeKojaBrise = $db->real_escape_string($_SESSION['username']['Ime']);
$prezimeOsobeKojaBrise = $db->real_escape_string($_SESSION['username']['Prezime']);

switch ($akcija){
    case 'korisnik':
        if($tip == 'u'){
            $db->autocommit(false);
            $query = "SELECT Ime, Prezime FROM Korisnik WHERE idKorisnika = ?";
            $preparedQuery = $db->prepare($query);
            $preparedQuery->bind_param("i", $id);
            if($preparedQuery->execute()){
                $preparedQuery->bind_result($ime, $prezime);
                $preparedQuery->fetch();
                $preparedQuery->close();
                $query = "DELETE FROM Korisnik WHERE idKorisnika = ?";
                $preparedQuery = $db->prepare($query);
                $preparedQuery->bind_param("i", $id);
                if($preparedQuery->execute()){
                    $preparedQuery->close();
                    $tipAkcije = "DELETE";
                    $opisAkcije = 'Korisnik $idOsobeKojaBrise ($imeOsobeKojaBrise $prezimeOsobeKojaBrise) je obrisao korisnika $id ($ime $prezime).';
                    $query = "INSERT INTO Log VALUES (?, ?, ?, now())";
                    $preparedQuery = $db->prepare($query);
                    $preparedQuery->bind_param("iss", $idOsobeKojaBrise, $tipAkcije, $opisAkcije);
                    if($preparedQuery->execute()){
                        $db->commit();
                        echo "Korisnik je uspesno obrisan!";
                        return;
                    }else{
                        $db->rollback();
                        die("Postoji problem unosom informacija o brisanju!");
                    }
                }else{
                    $db->rollback();
                    die("Postoji problem sa brisanjem korisnika!");
                }
            }else{
                $db->rollback();
                die("Planirate da obrisete korisnika koji ne postoji u bazi podataka!");
            }
        }else{
            die("Nedovoljne privilegije za brisanje korisnika!");
        }
        break;
    default:
        break;
}

header("Location: ../public/");