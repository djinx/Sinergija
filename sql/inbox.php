<?php
/**
 * Created by PhpStorm.
 * User: Ludi Burekdzija
 * Date: 12/01/2017
 * Time: 18:54
 */

require_once('Database.php');

$db = Database::getInstance();

$user = $_SESSION['username']['idKorisnika'];

if (isset($_POST['view_old'])) {
    $user = $_SESSION['username']['idKorisnika'];
    $query = "SELECT idPosiljaoca, poruka, naslov, datum  FROM `privatna poruka` WHERE idPrimaoca = ?";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("i", $user);
    if ($preparedQuery->execute()) {
        $preparedQuery->bind_result($id, $poruka, $naslov, $datum);
        while ($preparedQuery->fetch()) {
            echo "<table border=1>";
            echo "<tr><td>";
            echo "Naslov: ";
            echo $naslov;
            echo "</td></tr>";
            echo "<tr><td>";
            echo "Datum: ";
            echo $datum;
            echo "</td></tr>";
            echo "<tr><td>";
            echo "From: ";
            echo $id;
            echo " ";
            echo "</td></tr>";
            echo "<tr><td>";
            echo "Message: ";
            echo $poruka;
            echo "</td></tr>";
            echo "</br>";
        }
    }
}

header("Location: ../public/");