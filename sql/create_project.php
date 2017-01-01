<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/31/2016
 * Time: 1:49 PM
 */

require_once('Database.php');

$db = Database::getInstance();

$errors = array();

//provera naziva
if(!empty($_POST['NazivProjekta'])){
    $naziv = $db->real_escape_string(trim($_POST['NazivProjekta']));
}else{
    $errors[] = "Molimo unesite naziv projekta!";
}

//provera naziva
if(!empty($_POST['OpisProjekta'])){
    $opis = $db->real_escape_string(trim($_POST['OpisProjekta']));
}else{
    $errors[] = "Molimo unesite opis projekta!";
}

$datumPR = $_POST['DatumPocetkaRadaProjekta'];
$pr = date('Y-m-d', strtotime($datumPR));
$datumKR = $_POST['DatumKrajaRadaProjekta'];
$kr = date('Y-m-d', strtotime($datumKR));
$datumPD = $_POST['DatumPocetkaDogadjaja'];
$pd = date('Y-m-d', strtotime($datumPD));
$datumKD = $_POST['DatumKrajaDogadjaja'];
$kd = date('Y-m-d', strtotime($datumKD));


$query = 'INSERT INTO `projekat`(`idProjekta`, `naziv`, `opis`, `Pocetak_rada`, `Kraj_rada`, `Pocetak_dogadjaja`, `Kraj_dogadjaja`) VALUES (NULL, ?, ?, ?, ? , ?, ?)';
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("ssssss", $naziv, $opis, $pr, $kr, $pd, $kd);
$preparedQuery->execute();

$query = 'SELECT max(idProjekta) FROM projekat';
$result=mysqli_query($db, $query) or die("Problem prilikom izvrsavanja upita");
$row=mysqli_fetch_array($result);

echo $naziv." ".$row[0]." ".$opis;

header("Location: ../public/");