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
$uploaddir = "../uploads/";
$uploadfile = $uploaddir.basename($slika);

$bytesMax = 52428800;
$ok = ($_FILES["nova_slika"]["size"] <= $bytesMax);

$nazad = "<strong><a href='../public/' >Klikni</a> da se vratis na pocetnu stranu.</strong><br>";
?>

<!DOCTYPE HTML>
<!--
	Hyperspace by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Sinergija</title>
        <meta charset="utf-8" />
    </head>
    <body>
        <div>
            <?php
                if ($ok) {
                    if (move_uploaded_file($_FILES['nova_slika']['tmp_name'], $uploadfile)) {
                        echo "Slika je uspešno uploadovana.<br>";

                        $sql = "update Korisnik set Slika = ? where Nadimak = ?";
                        $preparedQuery = $db->prepare($sql);
                        $path = "http://127.0.0.1/edsa-www/Sinergija/uploads/".basename($slika);
                        $nadimak = trim($_POST['nadimak']);
                        $preparedQuery->bind_param("ss", $path, $nadimak);
                        $preparedQuery->execute();
                        $_SESSION['username']['Slika'] = $path;

                    } else {
                        echo "Slika <strong>nije</strong> uspešno uploadovana! ";
                    }
                } else {
                    echo "Slika <strong>prevazilazi maksimalnu dozvoljenu veličinu fajla</strong>! ";
                }
                echo $nazad;
            ?>
        </div>

    </body>
</html>