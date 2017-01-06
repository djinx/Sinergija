<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/2/2017
 * Time: 3:19 PM
 */


require_once('Database.php');

$db = Database::getInstance();

$errors = array();

$projekat = $_POST['ProjekatIdP'];
$prijatelj = $_POST['Prijatelj'];
$zaduzen = $_POST['Zaduzen'];


//upis podataka iz forme u bazu
$query =
        " INSERT INTO `zaduzen`(`idKorisnika`, `idProjekta`, `idSponzora`, `Status`) 
          VALUES (?, ?, ?, 'U pregovorima')";
$preparedQuery = $db->prepare($query);
$preparedQuery->bind_param("sss", $zaduzen, $projekat, $prijatelj);
$preparedQuery->execute();

header("Location: ../public/");