<?php


require_once('Database.php');

$db = Database::getInstance();
$query='select idKorisnika, Ime, Prezime, Telefon, `E-mail`, Slika, Tip from korisnik where idKorisnika=1';
$result=mysqli_query($db, $query) or die("Problem sa upitom");
$message="";
$row=mysqli_fetch_assoc($result);
$message.=$row['idKorisnika'].">".$row['Ime'].">".$row['Prezime'].">".$row['Telefon'].">".$row['E-mail'].">".$row['Slika'].">".$row['Tip'];

echo $message;
?>