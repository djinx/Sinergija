<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 1/1/2017
 * Time: 12:59 PM
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_SESSION['username'])){

    $idKorisnika = intval($_SESSION['username']['idKorisnika']);
    $num = $_GET['num'];
    $query = "SELECT p.idProjekta, p.naziv, p.opis, p.pocetak_rada, p.pocetak_dogadjaja, p.kraj_dogadjaja, t.naziv, k.ime, k.prezime, k.nadimak  ";
    $query = $query."FROM projekat p, ucestvuje u, tim t, koordinira ko, korisnik k  ";
    $query = $query."WHERE u.idKorisnika = ? AND p.idProjekta = u.idProjekta  ";
    $query = $query."AND t.idTima = u.idTima AND ko.idProjekta = p.idProjekta AND k.idKorisnika = ko.idKorisnika  ";

    if(intval($_GET['num']) != -1){
        $query = $query." LIMIT ?";
    }
    if($preparedQuery = $db->prepare($query)){
        if(intval($_GET['num']) != -1){
            $preparedQuery->bind_param("ii", $idKorisnika, $num);
        }else{
            $preparedQuery->bind_param("i", $idKorisnika);
        }

        if($preparedQuery->execute()){
            $preparedQuery->bind_result($idProjekta, $nazivP, $opis, $pocetakR, $pocetakD, $krajD, $nazivT, $ime, $prezime, $nadimak);
            $ordnum = 1;
            while($preparedQuery->fetch()){
                $type = "";
                $date1 = new DateTime($pocetakD);
                $date2 = new DateTime(date('Y-m-d'));
                if(date_diff($date1, $date2, true)->format('%a') < 7){
                    $type = "alert";
                }else if(date_diff($date1, $date2, true)->format('%a') < 14){
                    $type = "warning";
                }
                ?>
                <div class="callout <?php echo $type; ?>">
                    <h4><?php echo $nazivP; ?></h4>
                    <h5>Tim: <?php echo $nazivT; ?></h5>
                    <?php $idDiv = "p".$ordnum; ?>
                    <div id="<?php echo $idDiv; ?>" style="display: none;">
                        <p> <?php echo $opis; ?> </p>
                        <p> Datum početka rada na projektu: <?php echo $pocetakR; ?> </p>
                        <p> Datum početka događaja: <?php echo $pocetakD; ?> </p>
                        <p> Datum kraja događaja: <?php echo $krajD; ?> </p>
                    </div>
                    <p>Koordinator: <?php echo $ime." ".$prezime." (".$nadimak.")"; ?></p>
                    <div class="button-group">
                        <button type="button" class="button" onclick="procitaj_detalje('<?php echo $idDiv; ?>')">Pročitaj detalje</button>
                        <button type="button" class="button" onclick="zavrsi_projekat(<?php echo $idProjekta; ?>)" >Završi projekat</button>
                    </div>
                </div>
                <?php
                $ordnum++;
            }
            $preparedQuery->close();
            return true;
        }else{
            var_dump($db->error);
            die();
        }
    }else{
        var_dump($db->error);
        die();
    }

}else{
    die('Postoji problem sa dohvatanjem projekata!');
}