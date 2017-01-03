<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2.1.2017
 * Time: 17:19
 */

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_POST['idP']) && isset($_POST['idK'])){

    $idProjekta = intval($_POST['idP']);
    $idKorisnika = intval($_POST['idK']);

    //upit za izdvajanje podataka o projektu
    $query =
        "SELECT p.naziv, p.opis, p.Pocetak_rada, p.Pocetak_dogadjaja, p.Kraj_dogadjaja
         FROM projekat p 
         WHERE p.idProjekta = ?";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("i", $idProjekta);

    if($preparedQuery->execute()){
        $preparedQuery->bind_result($nazivProjekta, $opis, $pocetakRada, $pocetakDogadjaja, $krajDogadjaja);
        $preparedQuery->fetch();
    }else{
        echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        $nazivProjekta = "";
        $opis = "";
        $pocetakRada = "";
        $pocetakDogadjaja = "";
        $krajDogadjaja = "";
    }

    $preparedQuery->close();

    $query =
        " SELECT k.ime, k.prezime, k.nadimak 
          FROM korisnik k JOIN koordinira ko ON ko.idKorisnika=k.idKorisnika 
          WHERE idProjekta = ? ";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("i", $idProjekta);

    if($preparedQuery->execute()){
        $preparedQuery->bind_result($ime, $prezime, $nadimak);
        $koordinatori = "";
        while($preparedQuery->fetch()){
            $koordinatori .= $ime." ".$prezime." (".$nadimak."), ";
        }
    }else{
        echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        $koordinatori = "";
    }

    $preparedQuery->close();

    $query =
        " SELECT t.idTima, naziv 
          FROM tim t JOIN ucestvuje u ON t.idTima = u.idTima 
          WHERE u.idKorisnika = ? AND u.idProjekta = ?  ";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("ii", $idKorisnika, $idProjekta);

    if($preparedQuery->execute()){
        $preparedQuery->bind_result($idTima, $nazivTima);
        $preparedQuery->fetch();
    }else{
        echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        $idTima = 0;
        $nazivTima = "";
    }

    $preparedQuery->close();

    $query =
        " SELECT concat(ime, \" \", prezime, \" (\", nadimak, \")\") 
          FROM korisnik k JOIN koordinira ko ON k.idKorisnika = ko.idKorisnika 
          WHERE ko.idTima = ? AND ko.idProjekta = ?  ";
    $preparedQuery = $db->prepare($query);
    $preparedQuery->bind_param("ii", $idTima, $idProjekta);

    if($preparedQuery->execute()){
        $preparedQuery->bind_result($koordinator);
        $preparedQuery->fetch();
    }else{
        echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        $koordinator = "";
    }

    $preparedQuery->close();
?>
    <h4>Naziv projekta: <?php echo $nazivProjekta; ?></h4>

    <h5>Tim: <?php echo $nazivTima; ?></h5>
    <p>Koordinator tima: <?php echo $koordinator; ?></p>

    <p> <?php echo $opis; ?> </p>
    <p> Datum početka rada na projektu: <?php echo $pocetakRada; ?> </p>
    <p> Datum početka događaja: <?php echo $pocetakDogadjaja; ?> </p>
    <p> Datum kraja događaja: <?php echo $krajDogadjaja; ?> </p>

    <p>Koordinatori: <?php echo substr($koordinatori, 0, strlen($koordinatori)-2); ?></p>
    <div class="button-group">
        <button type="button" class="button" onclick="dodaj_ucesnika(<?php echo $idProjekta; ?>)" >Dodaj učesnika</button>
        <button type="button" class="button" onclick="dodaj_koordinatora(<?php echo $idProjekta; ?>)" >Dodaj koordinatora</button>
        <button type="button" class="button" onclick="dodaj_prijatelja(<?php echo $idProjekta; ?>)" >Dodaj prijatelja</button>
    </div>
    <button type="button" class="button" onclick="zavrsi_projekat(<?php echo $idProjekta; ?>)" >Završi projekat</button>
    <button class="expanded button" onclick="$('#informacije-Projekat').empty()">Sakrij</button>

<?php
    $preparedQuery->close();

}else{
    echo "Postoji greška u zahtevu. Pokušajte ponovo!";
}

