<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3.1.2017
 * Time: 16:04
 *
 * Ovaj skript dohvata sve obaveze ulogovanog korisnika sa njihovim informacijama.
 */

session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_SESSION['username'])){

    $idKorisnika = intval($_SESSION['username']['idKorisnika']);

    $query = "SELECT o.idObaveze, o.Naziv, o.Opis, o.Datum_pocetka, o.Datum_Zavrsetka, o.Deadline, t.Naziv 
        FROM `ima obavezu` io 
            JOIN obaveza o ON io.idObaveze = o.idObaveze 
            JOIN tim t ON t.idTima = o.idTima 
        WHERE io.idKorisnika = ? 
        ORDER BY o.Deadline";
    if($preparedQuery = $db->prepare($query)){
        $preparedQuery->bind_param("i", $idKorisnika);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($idObaveze, $naziv, $opis, $datumPocetka, $datumZavrsetka, $deadline, $tim);
            $ordnum = 1;
            while($preparedQuery->fetch()){
                $type = "";
                $date1 = new DateTime($deadline);
                $date2 = new DateTime(date('Y-m-d'));
                if(date_diff($date1, $date2, true)->format('%a') < 7){
                    $type = "alert";
                }else if(date_diff($date1, $date2, true)->format('%a') < 14){
                    $type = "warning";
                }
                if($datumZavrsetka != null){
                    $type = "success";
                }
                ?>
                <div class="callout <?php echo $type; ?>">
                    <h5><?php echo $naziv; ?></h5>
                    <?php $idDiv = "so".$ordnum; ?>
                    <div id="<?php echo $idDiv; ?>" style="display: none;">
                        <p> <?php echo $opis; ?> </p>
                        <p> Datum početka: <?php echo $datumPocetka; ?> </p>
                    <?php
                    if($datumZavrsetka != null){
                    ?>
                        <p> Datum završetka: <?php echo $datumZavrsetka; ?> </p>
                    <?php
                    }
                    ?>
                    </div>
                    <p>Deadline: <?php echo $deadline; ?></p>
                    <div class="button-group">
                        <button type="button" class="button" onclick="procitaj_detalje_obaveze('<?php echo $idDiv; ?>')">Pročitaj detalje</button>
                        <button type="button" class="button" onclick="odustani_od_obaveze('<?php echo $idObaveze; ?>')">Odustani</button>
                        <button type="button" class="button" onclick="zavrsi_obavezu(<?php echo $idObaveze; ?>)" >Završi obavezu</button>
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
    die('Postoji problem sa dohvatanjem obaveza!');
}
?>