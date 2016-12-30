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
        $query = "SELECT idTima, Naziv FROM `tim`";
        $result=mysqli_query($db, $query) or die("Problem prilikom izvrsavanja upita");

        /* sve podatke koje citamo formatiracemo na nivou niske */
        $message="";
        while($row=mysqli_fetch_assoc($result)){
            $message.=$row['idTima']."+".$row['Naziv']."::";
        }

        break;
    case 'citaj_korisnike':
        echo "";
        break;
    default:
        break;
}

echo $message;
?>