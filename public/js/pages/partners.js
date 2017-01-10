/**
 * Created by Admin on 30.12.2016.
 */

function ucitaj_zaduzene_prijatelje() {
    $.ajax({
        url: '../sql/info.php',
        data: {akcija: 'citaj_zaduzene_prijatelje'},
        method: 'post',
        success: function(rezultat) {
            var $listaPrijatelja =  $("div.listaPrijatelja");
            $listaPrijatelja.empty();
            $listaPrijatelja.append(rezultat);
            console.log("Dohvaceni su prijatelji");
            //console.log(rezultat);
            $listaPrijatelja.foundation();
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju prijatelja!");
            console.log(rezultat);
        }
    });
}

$(document).ready(function(){
    ucitaj_zaduzene_prijatelje();
});