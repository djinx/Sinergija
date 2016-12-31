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
    case 'zavrsi_obavezu':
        $id = $_GET['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE , `Odradjena`=1 WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        break;
    default:
        break;

}

echo $message;
?>