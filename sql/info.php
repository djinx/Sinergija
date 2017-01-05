<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/30/2016
 * Time: 11:17 AM
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(!isset($_GET['akcija']))
    exit();

$akcija = $_GET['akcija'];
$message="";

switch($akcija){
    case 'citaj_timove':
        $query = "SELECT `idTima`, `Naziv` FROM `tim`";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idTima, $naziv);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idTima . "+" . $naziv . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();

        break;
    case 'citaj_korisnike':
        $query = "SELECT `idKorisnika`, `Ime`, `Prezime` FROM `korisnik`";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_neucesnike':
        $idProjekta = $_GET['id'];
        $query =
            " SELECT `idKorisnika`, `Ime`, `Prezime` 
              FROM `korisnik` 
              WHERE `idKorisnika` not in (SELECT `idKorisnika` 
                                          FROM `ucestvuje` 
                                          WHERE idProjekta = ?)";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idProjekta);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_ucesnike':
        $idProjekta = $_GET['id'];
        $query =
            " SELECT k.idKorisnika, k.ime, k.prezime 
              FROM korisnik k, ucestvuje u 
              WHERE idProjekta = ?
              AND k.idKorisnika = u.idKorisnika
              AND k.idKorisnika not in (SELECT ko.idKorisnika 
                                        FROM koordinira ko
                                       	WHERE ko.idKorisnika = k.idKorisnika
                                       	  AND ko.idProjekta = ?) ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("ii", $idProjekta, $idProjekta);
        if($preparedQuery->execute()) {
            $result = $preparedQuery->get_result();
            if ($result->num_rows > 0) {
                // odgovor koji se salje
                $message = "";
                while ($row = $result->fetch_assoc()) {
                    $message .= $row['idKorisnika'] . "+" . $row['ime'] . "+" . $row['prezime'] . "::";
                }
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_sve_ucesnike':
        $idProjekta = $_GET['id'];
        $query =
            " SELECT k.idKorisnika, k.ime, k.prezime 
              FROM korisnik k, ucestvuje u 
              WHERE idProjekta = ?
              AND k.idKorisnika = u.idKorisnika ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idProjekta);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_prijatelje':
        $query = "SELECT idPrijatelja, naziv FROM prijatelji ";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()) {
            $result = $preparedQuery->get_result();
            if ($result->num_rows > 0) {
                // odgovor koji se salje
                $message = "";
                while ($row = $result->fetch_assoc()) {
                    $message .= $row['idPrijatelja'] . "+" . $row['naziv'] . "::";
                }
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }

        $preparedQuery->close();
        break;
    case 'zavrsi_obavezu':
        $id = $_GET['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE , `Odradjena`=1 WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    case 'odustani_od_obaveze':
        $id = $_GET['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    case 'zavrsi_projekat':
        $id = $_GET['id'];
        $query = "UPDATE `projekat` SET `Kraj_rada`=CURRENT_DATE WHERE idProjekta=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    default:
        break;

}

echo $message;
