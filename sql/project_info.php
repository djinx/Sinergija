<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2.1.2017
 * Time: 17:19
 */

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_POST['id'])){

    $idProjekta = intval($_POST['id']);

    $query =
        "SELECT p.naziv, p.opis, p.Pocetak_rada, p.Pocetak_dogadjaja, p.Kraj_dogadjaja, t.Naziv, k.Ime, k.Prezime, k.Nadimak
         FROM projekat p 
            JOIN ucestvuje u ON p.idProjekta = u.idProjekta
            JOIN tim t ON u.idTima = t.idTima
            JOIN koordinira ko ON p.idProjekta = ko.idProjekta
            JOIN korisnik k ON ko.idKorisnika = k.idKorisnika 
         WHERE p.idProjekta = ?";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("i", $idProjekta);

    if($preparedQuery->execute()){
        $preparedQuery->bind_result($nazivProjekta, $opis, $pocetakRada, $pocetakDogadjaja, $krajDogadjaja, $nazivTima, $ime, $prezime, $nadimak);
        $koordinatori = "";
        while($preparedQuery->fetch()){
            $koordinatori .= $ime." ".$prezime." (".$nadimak."), ";
        }
        ?>
        <h4>Naziv projekta: <?php echo $nazivProjekta; ?></h4>
        <h5>Tim: <?php echo $nazivTima; ?></h5>

        <p> <?php echo $opis; ?> </p>
        <p> Datum početka rada na projektu: <?php echo $pocetakRada; ?> </p>
        <p> Datum početka događaja: <?php echo $pocetakDogadjaja; ?> </p>
        <p> Datum kraja događaja: <?php echo $krajDogadjaja; ?> </p>

        <p>Koordinator: <?php echo substr($koordinatori, 0, strlen($koordinatori)-2); ?></p>
<?php
        $preparedQuery->close();
    }else{
        echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
    }

}else{
    echo "Postoji greška u zahtevu. Pokušajte ponovo!";
}