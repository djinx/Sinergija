<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/31/2016
 * Time: 1:49 PM
 */

session_start();

require_once('Database.php');

$db = Database::getInstance();

$errors = array();

$idKorisnika = $_SESSION['username']['idKorisnika'];

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
$datumPD = $_POST['DatumPocetkaDogadjaja'];
$pd = date('Y-m-d', strtotime($datumPD));
$datumKD = $_POST['DatumKrajaDogadjaja'];
$kd = date('Y-m-d', strtotime($datumKD));
$idTima = $_POST['Tim'];


$db->autocommit(false);
//unos novog projekta
$query =
    " INSERT INTO `projekat`(`idProjekta`, `naziv`, `opis`, `Pocetak_rada`, `Kraj_rada`, `Pocetak_dogadjaja`, `Kraj_dogadjaja`)
      VALUES (NULL, ?, ?, ?, NULL , ?, ?)";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("sssss", $naziv, $opis, $pr, $pd, $kd);
if($preparedQuery->execute()){
    $preparedQuery->close();

    //izdvajanje identifikatora novog projekta
    $query = "SELECT max(`idProjekta`) FROM `Projekat`";
    $preparedQuery = $db->prepare($query);
    if($preparedQuery->execute()) {
        $preparedQuery->bind_result($idProjekta);
        $preparedQuery->fetch();
        $preparedQuery->close();

        //unos korisnika koji je napravio projekat u tabelu ucestvuje
        $query =
            " INSERT INTO `ucestvuje` (`idKorisnika`, `idProjekta`, `idTima`)
              VALUES (?, ?, ?)";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("iii", $idKorisnika, $idProjekta, $idTima);
        if($preparedQuery->execute()){
            $db->commit();
            // echo "Projekat je uspesno napravljen!";
            header("Location: ../public/");
            return;
        }else{
            $db->rollback();
            die("Postoji problem unosom informacija o ucesniku!");
        }
    } else{
        $db->rollback();
        die("Postoji problem sa dohvatanjem informacija o novom projektu");
    }
} else{
    $db->rollback();
    die("Postoji problem sa unosom informacija o novom projektu");
}

header("Location: ../public/");