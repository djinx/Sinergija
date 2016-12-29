<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/29/2016
 * Time: 1:09 PM
 */

require_once('Database.php');

$db = Database::getInstance();

$naziv = $_POST['NazivObaveze'];
$opis = $_POST['OpisObaveze'];
$datum = $_POST['DatumPocetkaObaveze'];
$deadline = $_POST['Deadline'];
$tim = $_POST['Tim'];
$datum1 =  date('Y-m-d', strtotime($datum));
$deadline1 =  date('Y-m-d', strtotime($deadline));


$sql = 'insert into obaveza(`idObaveze`, `Naziv`, `Opis`, `Datum_pocetka`, `Deadline`, `Odradjena`, `idTima`) VALUES(NULL, ?, ?, ?, ?, 0, ?)';
$preparedQuery = $db->prepare($sql);
$preparedQuery->bind_param("ssssi", $naziv, $opis, $datum1, $deadline1, $tim);

$preparedQuery->execute();

echo $naziv." ".$opis." ".$datum1." ".$deadline1." ".$tim;

header("Location: ../public/");
?>
