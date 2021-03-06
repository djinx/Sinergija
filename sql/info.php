<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/30/2016
 * Time: 11:17 AM
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(!isset($_POST['akcija']))
    exit();

$akcija = $_POST['akcija'];
$message="";

switch($akcija){
    case 'citaj_timove':
        $query = "SELECT `idTima`, `Naziv` FROM `tim`";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idTima, $naziv);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idTima . "+" . $naziv . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();

        break;
    case 'citaj_korisnike':
        $query = "SELECT `idKorisnika`, `Ime`, `Prezime` FROM `korisnik`";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_podatke_o_korisniku':
        $message = $_SESSION['username']['Telefon'] . "::" . $_SESSION['username']['Email'] . "::" . $_SESSION['username']['Nadimak'];
        break;
    case 'citaj_neucesnike':
        $idProjekta = $_POST['id'];
        $query =
            " SELECT `idKorisnika`, `Ime`, `Prezime` 
              FROM `korisnik` 
              WHERE `idKorisnika` not in (SELECT `idKorisnika` 
                                          FROM `ucestvuje` 
                                          WHERE idProjekta = ?)";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idProjekta);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_ucesnike':
        $idProjekta = $_POST['id'];
        $query =
            " SELECT k.idKorisnika, k.ime, k.prezime 
              FROM korisnik k, ucestvuje u 
              WHERE idProjekta = ?
              AND k.idKorisnika = u.idKorisnika
              AND k.idKorisnika not in (SELECT ko.idKorisnika 
                                        FROM koordinira ko
                                       	WHERE ko.idKorisnika = k.idKorisnika
                                       	  AND ko.idProjekta = ?) ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("ii", $idProjekta, $idProjekta);
        if($preparedQuery->execute()) {
            $result = $preparedQuery->get_result();
            if ($result->num_rows > 0) {
                // odgovor koji se salje
                $message = "";
                while ($row = $result->fetch_assoc()) {
                    $message .= $row['idKorisnika'] . "+" . $row['ime'] . "+" . $row['prezime'] . "::";
                }
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_sve_ucesnike':
        $idProjekta = $_POST['id'];
        $query =
            " SELECT k.idKorisnika, k.ime, k.prezime 
              FROM korisnik k, ucestvuje u 
              WHERE idProjekta = ?
              AND k.idKorisnika = u.idKorisnika ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idProjekta);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idKorisnika, $ime, $prezime);
            // odgovor koji se salje
            $message = "";
            while ($preparedQuery->fetch()) {
                $message .= $idKorisnika . "+" . $ime. "+" . $prezime . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_tipove':
        $query = "SELECT DISTINCT tip FROM `prijatelji` ";
        $preparedQuery = $db->prepare($query);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($tip);
            $message = "";
            while($preparedQuery->fetch())
                $message .= $tip."::";
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_podtipove':
        $tip = $_POST['tip'];
        $query = "SELECT DISTINCT podtip FROM `prijatelji` WHERE tip = ? ";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("s", $tip);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($podtip);
            $message = "";
            while($preparedQuery->fetch())
                $message .= $podtip."::";
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_prijatelje':
        $id = $_POST['id'];
        $tip = $_POST['tip'];
        $podtip = $_POST['podtip'];
        $query =
            " SELECT idPrijatelja, naziv 
              FROM prijatelji 
              WHERE tip = ? 
              AND podtip = ? 
              AND NOT EXISTS (SELECT * FROM zaduzen WHERE idPrijatelja = idSponzora AND idProjekta = ?)";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("ssi", $tip, $podtip, $id);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idPrijatelja, $naziv);
            $message = "";
            while($preparedQuery->fetch()) {
                // odgovor koji se salje
                $message .= $idPrijatelja . "+" . $naziv . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }

        $preparedQuery->close();
        break;
    case 'citaj_sve_prijatelje':
        $tip = $_POST['tip'];
        $podtip = $_POST['podtip'];
        $query = "SELECT idPrijatelja, naziv FROM prijatelji WHERE tip = ? AND podtip = ?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("ss", $tip, $podtip);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($idPrijatelja, $naziv);
            $message = "";
            while($preparedQuery->fetch()) {
                // odgovor koji se salje
                $message .= $idPrijatelja . "+" . $naziv . "::";
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }

        $preparedQuery->close();
        break;
    case 'citaj_podatke_prijatelji':
        $id = $_POST['id'];
        $query =
            " SELECT naziv, broj_telefona, email, veb_sajt, ime_kontakta, adresa
              FROM prijatelji 
              WHERE idPrijatelja = ?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        if($preparedQuery->execute()) {
            $preparedQuery->bind_result($naziv, $broj, $email, $veb, $ime, $adresa);
            $message = "";
            while($preparedQuery->fetch()) {
                // odgovor koji se salje
                $message .= $naziv . "::" . $broj . "::" . $email . "::" . $veb . "::" . $ime . "::" . $adresa;
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }

        $preparedQuery->close();
        break;
    case 'citaj_zaduzene_tipove':
        $idProjekta = intval($_POST['idProjekta']);
        $idKorisnika = intval($_SESSION['username']['idKorisnika']);
        $query =
            "SELECT DISTINCT pr.tip 
              FROM prijatelji pr
                JOIN zaduzen z ON z.idSponzora = pr.idPrijatelja
              WHERE z.idProjekta = ?
                AND z.idKorisnika = ?;";
        if($preparedQuery = $db->prepare($query)){
            $preparedQuery->bind_param("ii", $idProjekta, $idKorisnika);
            if($preparedQuery->execute()){
                $preparedQuery->bind_result($tip);
                while($preparedQuery->fetch()){
                    ?>
                    <option value="<?php echo $tip; ?>"><?php echo $tip; ?></option>
                    <?php
                }
            }
            else{
                echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
            }
            $preparedQuery->close();
        }else{
            die("Problem u upitu: ".$db->error);
        }
        break;
    case 'citaj_zaduzene_podtipove':
        $idProjekta = intval($_POST['idProjekta']); echo $idProjekta;
        $idKorisnika = intval($_SESSION['username']['idKorisnika']); echo $idKorisnika;
        $tip = $db->real_escape_string($_POST['tip']); echo $tip;
        $query =
            "SELECT DISTINCT pr.podtip 
              FROM prijatelji pr 
                JOIN zaduzen z ON z.idSponzora = pr.idPrijatelja
              WHERE z.idProjekta = ?
                AND z.idKorisnika = ?
                AND pr.tip = ?;";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("iis", $idProjekta, $idKorisnika, $tip);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($podtip);
            while($preparedQuery->fetch()){
            ?>
                <option value="<?php echo $podtip; ?>"><?php echo $podtip; ?></option>
            <?php
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_zaduzene_prijatelje_select':
        $idProjekta = intval($_POST['idProjekta']);
        $idKorisnika = intval($_SESSION['username']['idKorisnika']);
        $tip = $db->real_escape_string($_POST['tip']);
        $podtip = $db->real_escape_string($_POST['podtip']);
        $query =
            "SELECT pr.idPrijatelja, pr.Naziv 
              FROM prijatelji pr 
                JOIN zaduzen z ON z.idSponzora = pr.idPrijatelja
              WHERE z.idProjekta = ?
                AND z.idKorisnika = ?
                AND pr.tip = ?
                AND pr.podtip = ?;";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("iiss", $idProjekta, $idKorisnika, $tip, $podtip);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($id, $prijatelj);
            while($preparedQuery->fetch()){
                ?>
                <option value="<?php echo $id; ?>"><?php echo $prijatelj; ?></option>
                <?php
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_status_zaduzenja_prijatelja':
        $idProjekta = intval($_POST['idProjekta']);
        $idKorisnika = intval($_SESSION['username']['idKorisnika']);
        $idPrijatelja = intval($_POST['idPrijatelja']);
        $query =
            "SELECT z.Status, z.Napomena 
              FROM zaduzen z
              WHERE z.idProjekta = ?
                AND z.idKorisnika = ?
                AND z.idSponzora = ?;";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("iii", $idProjekta, $idKorisnika, $idPrijatelja);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($status, $napomena);
            while($preparedQuery->fetch()){
                $message .= $status.'::'.$napomena;
            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }
        $preparedQuery->close();
        break;
    case 'citaj_zaduzene_prijatelje':
        $idKorisnika = intval($_SESSION['username']['idKorisnika']);
        $prijatelji = array();
        $query =
            "SELECT pr.Naziv AS Naziv_prijatelja, pr.Tip, pr.Podtip, COALESCE(pr.Broj_telefona, ' ') AS Broj_telefona, COALESCE(pr.Email, ' ') AS Email, COALESCE(pr.Veb_sajt, ' ') AS Veb_sajt, COALESCE(pr.Ime_Kontakta, ' ') AS Ime_kontakta, COALESCE(pr.Adresa, ' ') AS Adresa, p.naziv AS Naziv_projekta, COALESCE(z.Status, ' ') AS Status, COALESCE(z.Napomena, ' ') AS Napomena
          FROM zaduzen z
            JOIN prijatelji pr ON z.idSponzora = pr.idPrijatelja
            JOIN projekat p ON z.idProjekta = p.idProjekta
          WHERE z.idKorisnika = ?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idKorisnika);
        if($preparedQuery->execute()) {
            $result = $preparedQuery->get_result();
            $num = $result->num_rows;
            while ($o = $result->fetch_object()){
                $prijatelji[$o->Tip][$o->Podtip][] = $o;
            }
            $preparedQuery->close();
            ?>
            <ul class="accordion" id="prijateljiAcc" data-accordion="prijateljiAcc" data-allow-all-closed="true" data-multi-expand="true">
                <?php
                foreach ($prijatelji as $tip => $podtipOstalo){
                    ?>
                    <li class="accordion-navigation is-active" data-accordion-item="" role="presentation">
                        <a href="#<?php echo $tip; ?>Data" role="tab" class="accordion-title" id="<?php echo $tip; ?>-heading" aria-controls="<?php echo $tip; ?>Data"><?php echo $tip; ?></a>
                        <div id="<?php echo $tip; ?>Data" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="<?php echo $tip; ?>-heading">
                            <ul class="tabs" data-tabs id="<?php echo $tip; ?>-tabs">
                                <?php
                                foreach ($podtipOstalo as $podtip => $ostalo){
                                    ?>
                                    <li class="tabs-title"><a href="#tab-<?php echo $podtip; ?>"><?php echo $podtip; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                            foreach ($podtipOstalo as $podtip => $ostalo){
                                ?>
                                <div class="tabs-content" data-tabs-content="<?php echo $tip; ?>-tabs">
                                    <div class="tabs-panel table-scroll" id="tab-<?php echo $podtip; ?>">
                                        <table class="unstriped">
                                            <thead>
                                            <tr>
                                                <th style="min-width: 150px;">Naziv</th>
                                                <th style="min-width: 150px;">Broj telefona</th>
                                                <th style="min-width: 250px;">Email</th>
                                                <th style="min-width: 150px;">Veb sajt</th>
                                                <th style="min-width: 250px;">Ime kontakta</th>
                                                <th style="min-width: 250px;">Adresa</th>
                                                <th style="min-width: 200px;">Naziv projekta</th>
                                                <th style="min-width: 150px;">Status</th>
                                                <th style="min-width: 300px;">Napomena</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($ostalo as $kljuc => $niz){
                                                if($niz->Tip == $tip && $niz->Podtip == $podtip){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $niz->Naziv_prijatelja; ?></td>
                                                        <td><?php echo $niz->Broj_telefona; ?></td>
                                                        <td><?php echo $niz->Email; ?></td>
                                                        <td><a href="http://<?php echo $niz->Veb_sajt; ?>" target="_blank"><?php echo $niz->Veb_sajt; ?></a></td>
                                                        <td><?php echo $niz->Ime_kontakta; ?></td>
                                                        <td><?php echo $niz->Adresa; ?></td>
                                                        <td><?php echo $niz->Naziv_projekta; ?></td>
                                                        <td><?php echo $niz->Status; ?></td>
                                                        <td><?php echo $niz->Napomena; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
            if($num){
            ?>
                <button type="button" class="button" name="napisiIzvestaj" id="napisiIzvestaj">Napiši izveštaj</button>
            <?php

            }
        }
        else{
            echo "Postoji problem sa dohvatanjem informacija. Pokušajte ponovo!";
        }

        break;
    case 'zavrsi_obavezu':
        $id = $_POST['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE , `Odradjena`=1 WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    case 'odustani_od_obaveze':
        $id = $_POST['id'];
        $query = "UPDATE Obaveza SET `Datum_zavrsetka`=CURRENT_DATE WHERE idObaveze=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    case 'zavrsi_projekat':
        $id = $_POST['id'];
        $query = "UPDATE `projekat` SET `Kraj_rada`=CURRENT_DATE WHERE idProjekta=?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    case 'citaj_primljene':
        $idPrimaoca = $_SESSION['username']['idKorisnika'];
        $query = 
            "SELECT `idPoruke`, `Nadimak`, `poruka`, `naslov`, `datum`, `procitana`, `Slika`
                FROM `privatna poruka` 
                    JOIN `korisnik` ON idPosiljaoca = idKorisnika 
                WHERE idPrimaoca = ?
                ORDER BY datum DESC";
        if($preparedQuery = $db->prepare($query)){
            $preparedQuery->bind_param("i", $idPrimaoca);

            if ($preparedQuery->execute()) {
                $preparedQuery->bind_result($idPoruke, $posiljaoc, $poruka, $naslov, $datum, $procitana, $slika);
                while ($preparedQuery->fetch()){
                    $poruka = str_replace(array("\\r\\n", "\\r", "\\n"), "<br/>", $poruka);
                    ?>
                    <div id="<?php echo "m".$idPoruke; ?>" class="message <?php 
                                                                    if(!$procitana){
                                                                        echo "alert unread";
                                                                    }else{
                                                                        echo "success";
                                                                    }
                                                                  ?> callout clearfix">
                        <img class="float-left" src="<?php echo $slika; ?>" width="51px;"/>
                        <div class="float-left" style="padding-left: 5px;">
                            <span id="<?php echo "naslov".$idPoruke;?>" onclick="prikazi_primljenu(<?php echo $idPoruke; ?>)" style="cursor: pointer;">
                                <?php echo $naslov; ?>
                            </span>
                            <br>
                            <span class="secondary label" id="<?php echo "posiljaoc".$idPoruke; ?>"><?php echo $posiljaoc; ?></span>
                            <div style='display: none;'>
                                <span id="<?php echo "primaoc".$idPoruke;?>">
                                    <?php echo $_SESSION['username']['Nadimak'];?>
                                </span>
                                <span id="<?php echo "datum".$idPoruke;?>">
                                    <?php echo $datum;?>
                                </span>
                                <p id="<?php echo "tekstPoruke".$idPoruke;?>">
                                    <?php echo $poruka;?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $preparedQuery->close();
            }
        }else{
            die("Postoji problem sa dohvatanjem informacija: ".$db->error);
        }


        break;
    case 'citaj_poslate':
        $idPosiljaoca = $_SESSION['username']['idKorisnika'];
        $query = 
            "SELECT `idPoruke`, `Nadimak`, `poruka`, `naslov`, `datum`, `procitana`, `Slika`
                FROM `privatna poruka` 
                    JOIN `korisnik` ON idPrimaoca = idKorisnika
                WHERE idPosiljaoca = ?
                ORDER BY datum DESC";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $idPosiljaoca);

        if ($preparedQuery->execute()) {
            $preparedQuery->bind_result($idPoruke, $primaoc, $poruka, $naslov, $datum, $procitana, $slika);
            while ($preparedQuery->fetch()){
                $poruka = str_replace(array("\\r\\n", "\\r", "\\n"), "<br/>", $poruka);

        ?>
                <div id="<?php echo "m".$idPoruke; ?>" class="message callout clearfix">
                    <img class="float-left" src="<?php echo $slika; ?>" width="51px;"/>
                    <div class="float-left" style="padding-left: 5px;">
                        <span href="#" id="<?php echo "naslov".$idPoruke;?>" onclick="prikazi_poslatu(<?php echo $idPoruke; ?>, <?php echo $procitana; ?>)" style="cursor: pointer;">
                            <?php echo $naslov ?>
                        </span>
                        <br>
                        <span class="secondary label" id="<?php echo "primaoc".$idPoruke; ?>">
                            <?php echo $primaoc; ?>
                        </span>
                        <div style='display: none;'>
                            <span id="<?php echo "posiljaoc".$idPoruke; ?>">
                                 <?php echo $_SESSION['username']['Nadimak']; ?>
                            </span>
                            <span id="<?php echo "datum".$idPoruke; ?>">
                                <?php echo $datum; ?>
                            </span>
                            <p id="<?php echo "tekstPoruke".$idPoruke;?>">
                                <?php echo $poruka;?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
            }
            $preparedQuery->close();
        }
        ?>


        <?php
        break;
    case 'procitaj_poruku':
        $id = $_POST['id'];
        $query =
            " UPDATE `privatna poruka`
              SET procitana = 1 
              WHERE idPoruke = ?";
        $preparedQuery = $db->prepare($query);
        $preparedQuery->bind_param("i", $id);
        $preparedQuery->execute();
        $preparedQuery->close();
        break;
    default:
        break;
}

echo $message;
