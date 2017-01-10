<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.1.2017
 * Time: 17:31
 */
session_start();

require_once ('Database.php');

$db = Database::getInstance();

function uporediObavestenja($prvo, $drugo){
    return -strcmp($prvo->vremeDatum, $drugo->vremeDatum);
}

if(isset($_SESSION['username']) && isset($_POST['num'])){

    $idKorisnika = intval($_SESSION['username']['idKorisnika']);
    $num = intval($_POST['num']);
    $svaObavestenja = array();
    $upiti = array();

    $upiti[] = "
      SELECT u.VremeDatum, CONCAT_WS(' ', 'Dodati ste na projekat', p.naziv, 'u tim', t.Naziv) AS opis
      FROM ucestvuje u
        JOIN projekat p ON u.idProjekta = p.idProjekta
        JOIN tim t ON u.idTima = t.idTima
      WHERE u.idKorisnika = ?";
    $upiti[] = "
      SELECT io.VremeDatum, CONCAT_WS(' ', 'Dobili ste novu obavezu', o.Naziv) AS opis
      FROM `ima obavezu` io
        JOIN obaveza o ON io.idObaveze = o.idObaveze
      WHERE io.idKorisnika = ?";
    $upiti[] = "
      SELECT z.VremeDatum, CONCAT_WS(' ', 'Zaduženi ste za prijatelja', pr.Naziv, 'na projektu', p.naziv) AS opis
      FROM zaduzen z
        JOIN projekat p ON z.idProjekta = p.idProjekta
        JOIN prijatelji pr ON z.idSponzora = pr.idPrijatelja
      WHERE z.idKorisnika = ?";
    $upiti[] = "
      SELECT k.VremeDatum, CONCAT_WS(' ', 'Odabrani ste da koordinirate timom', t.Naziv, 'na projektu', p.naziv) AS opis
      FROM koordinira k
        JOIN projekat p ON k.idProjekta = p.idProjekta
        JOIN tim t ON k.idTima = t.idTima
      WHERE k.idKorisnika = ?";

    foreach ($upiti as $kljuc=>$vrednost){
        $preparedQuery = $db->prepare($vrednost);
        $preparedQuery->bind_param("i", $idKorisnika);
        if($preparedQuery->execute()){
            $preparedQuery->bind_result($vremeDatum, $opis);
            while ($preparedQuery->fetch()){
                $o = new stdClass();
                $o->vremeDatum = $vremeDatum;
                $o->opis = $opis;
                $svaObavestenja[] = $o;
            }
            $preparedQuery->close();
        }else{
            die("Postoji problem sa dohvatanjem obavestenja o ucestvovanju na projektu!");
        }
    }

    usort($svaObavestenja, "uporediObavestenja");

    $num = ($num <= count($svaObavestenja)) ? $num : count($svaObavestenja);
    for ($i = 0; $i < $num; $i++){
        $vrednost = $svaObavestenja[$i];
    ?>
        <div class="callout secondary">
            <h5><?php echo $vrednost->opis; ?></h5>
            <h6><?php echo $vrednost->vremeDatum; ?></h6>
        </div>
    <?php
    }

}else{
    die("Postoji problem u zahtevu!");
}