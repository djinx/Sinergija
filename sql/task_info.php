<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 29.12.2016
 * Time: 18:14
 */
session_start();

require_once ('Database.php');

$db = Database::getInstance();

if(isset($_SESSION['username'])){

    $idKorisnika = intval($_SESSION['username']['idKorisnika']);
    $num = $_GET['num'];
    $query = "SELECT o.Naziv, o.Opis, o.Datum_pocetka, o.Deadline, t.Naziv FROM `ima obavezu` io JOIN obaveza o ON io.idObaveze = o.idObaveze JOIN tim t ON t.idTima = o.idTima WHERE o.Odradjena = 0 AND io.idKorisnika = ? ORDER BY o.Deadline";
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
            $preparedQuery->bind_result($naziv, $opis, $datumPocetka, $deadline, $tim);
            while($preparedQuery->fetch()){
                $type = "";
                $date1 = new DateTime($deadline);
                $date2 = new DateTime(date('Y-m-d'));
                if(date_diff($date1, $date2, true)->format('%a') < 7){
                    $type = "alert";
                }else if(date_diff($date1, $date2, true)->format('%a') < 14){
                    $type = "warning";
                }
                ?>
                <div class="callout <?php echo $type; ?>">
                    <h5><?php echo $naziv; ?></h5>
                    <p>Deadline: <?php echo $deadline; ?></p>
                    <div class="button-group">
                        <a href="#0" class="button">Pročitaj detalje</a>
                        <button type="button" class="button">Završi obavezu</button>
                    </div>
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
    die('Postoji problem sa dohvatanjem obaveza!');
}
?>