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
        $result=mysqli_query($db, $query) or die("Problem prilikom izvrsavanja upita");

        // odgovor koji se salje
        $message="";
        while($row=mysqli_fetch_assoc($result)){
            $message.=$row['idTima']."+".$row['Naziv']."::";
        }

        break;
    case 'citaj_korisnike':
        $query = "SELECT `idKorisnika`, `Ime`, `Prezime` FROM `korisnik`";
        $result=mysqli_query($db, $query) or die("Problem prilikom izvrsavanja upita");

        // odgovor koji se salje
        $message="";
        while($row=mysqli_fetch_assoc($result)){
            $message.=$row['idKorisnika']."+".$row['Ime']."+".$row['Prezime']."::";
        }
        break;
    case 'citaj_ucesnike':
        $query = "SELECT k.idKorisnika, k.ime, k.prezime ";
        $query = $query." FROM korisnik k, ucestvuje u ";
        $query = $query." WHERE idProjekta = ? ";
        $query = $query." AND k.idKorisnika = u.idKorisnika ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $_GET['id']);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        if($result->num_rows > 0) {
            // odgovor koji se salje
            $message = "";
            while ($row = $result->fetch_assoc()) {
                $message .= $row['idKorisnika'] . "+" . $row['ime'] . "+" . $row['prezime'] . "::";
            }
        }
        break;
    case 'citaj_prijatelje':
        $query = "SELECT idPrijatelja, naziv FROM prijatelji ";
        $result=mysqli_query($db, $query) or die("Problem prilikom izvrsavanja upita");

        // odgovor koji se salje
        $message="";
        while($row=mysqli_fetch_assoc($result)){
            $message.=$row['idPrijatelja']."+".$row['naziv']."::";
        }
        break;
    case 'zavrsi_obavezu':
        $id = $_GET['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE , `Odradjena`=1 WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        break;
    case 'odustani_od_obaveze':
        $id = $_GET['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        break;
    case 'zavrsi_projekat':
        $id = $_GET['id'];
        $query = "UPDATE `projekat` SET `Kraj_rada`=CURRENT_DATE WHERE idProjekta=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $message = "izvrsena izmena za projekat ".$id;
        break;
    default:
        break;

}

echo $message;
?>