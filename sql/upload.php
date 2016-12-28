<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/28/2016
 * Time: 5:19 PM
 */
session_start();

require_once('Database.php');

$db = Database::getInstance();

$korisnik = $_POST["nadimak"];

$slika = $_FILES["nova_slika"]["name"];
$uploaddir = "../uploads/".$korisnik."/";
$uploadfile = $uploaddir.basename($slika);

$bytesMax = 52428800;
$ok = ($_FILES["nova_slika"]["size"] <= $bytesMax);

if ($ok) {
    if(!file_exists($uploaddir)){
        mkdir($uploaddir);
    }
    if (move_uploaded_file($_FILES['nova_slika']['tmp_name'], $uploadfile)) {
        //echo "Slika je uspešno uploadovana.<br>";

        $sql = "update Korisnik set Slika = ? where Nadimak = ?";
        $preparedQuery = $db->prepare($sql);
        $nadimak = trim($_POST['nadimak']);
        $preparedQuery->bind_param("ss", $uploadfile, $nadimak);
        $preparedQuery->execute();
        $_SESSION['username']['Slika'] = $uploadfile;

    } else {
        //echo "Slika <strong>nije</strong> uspešno uploadovana! ";
    }
} else {
    //echo "Slika <strong>prevazilazi maksimalnu dozvoljenu veličinu fajla</strong>! ";
}

header("Location: ../public/");