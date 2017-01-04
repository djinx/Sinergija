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
    $query =
        " SELECT p.idProjekta, p.naziv, p.pocetak_dogadjaja, t.naziv 
          FROM projekat p, ucestvuje u, tim t 
          WHERE u.idKorisnika = ? AND p.idProjekta = u.idProjekta 
          AND t.idTima = u.idTima AND p.kraj_rada IS NULL  ";

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
            $preparedQuery->bind_result($idProjekta, $nazivP, $pocetakD, $nazivT);
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
                    <?php
                        if(isset($_SESSION['pages']['projects']) && $_SESSION['pages']['projects']) {
                            ?>
                            <div class="button-group">
                                <button type="button" class="button"
                                        onclick="procitaj_detalje_projekta(<?php echo $idProjekta; ?>)">Pročitaj detalje
                                </button>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <?php
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