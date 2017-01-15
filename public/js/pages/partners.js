/**
 * Created by Admin on 30.12.2016.
 */

var $formaPohraniIzvestaj;

/*
 * Broj projekata koji se dohvata u startu na ovoj stranici.
 * Vrednost je -1 ako treba dohvatiti sve projekte.
 */
var num_p = -1;

/**
 * Dohvata određen broj svih nezavršenih (aktivnih) projekata iz baze podataka na kojima prijavljeni korisnik učestvuje.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaProjekata" odgovarajućem <select> elementu.
 * @param num_p: broj projekata koji se dohvata iz baze podataka; -1 ako treba dohvatiti sve projekte.
 */
function dohvati_imena_projekata(num_p) {
    $.ajax({
        url: '../sql/projects_info.php',
        method: 'post',
        data: {num: num_p, akcija: 'select lista'},
        success: function(rezultat){
            console.log("Dohvaćeni su projekti!");

            var $listaProjekata = $("select.listaProjekata");
            $listaProjekata.html("");
            $listaProjekata.append('<option value=""></option>');
            $listaProjekata.append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju projekata!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}

function ucitaj_zaduzene_tipove(){
    var id = $("select.listaProjekata").val();
    if(id === ''){
        return;
    }
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_zaduzene_tipove', idProjekta: id},
        success: function(rezultat) {
            var $tip =  $("select.Tip");
            $tip.empty();
            $tip.append("<option value=''></option>");
            $tip.append(rezultat);
            console.log("Dohvaceni su tipovi prijatelja!");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o tipovima prijatelja!");
            console.log(rezultat);
        }
    });
}

function ucitaj_zaduzene_podtipove(){
    var id = $("select.listaProjekata").val();
    var tip = $("select.Tip").val();
    if(id === '' || tip === ''){
        return;
    }
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_zaduzene_podtipove', idProjekta: id, tip: tip},
        success: function(rezultat) {
            var $podtip =  $("select.Podtip");
            $podtip.empty();
            $podtip.append("<option value=''></option>");
            $podtip.append(rezultat);
            console.log("Dohvaceni su podtipovi prijatelja!");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o podtipovima prijatelja!");
            console.log(rezultat);
        }
    });
}

function ucitaj_zaduzene_prijatelje_select() {
    var id = $("select.listaProjekata").val();
    var tip = $("select.Tip").val();
    var podtip = $("select.Podtip").val();
    if(id === '' || tip === '' || podtip === ''){
        return;
    }
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_zaduzene_prijatelje_select', idProjekta: id, tip: tip, podtip: podtip},
        success: function(rezultat) {
            var $zaduzeniPrijatelji =  $("select.listaZaduzenihPrijatelja");
            $zaduzeniPrijatelji.empty();
            $zaduzeniPrijatelji.append("<option value=''></option>");
            $zaduzeniPrijatelji.append(rezultat);
            console.log("Dohvaceni su zaduzeni prijatelji!");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o zaduzenim prijateljima!");
            console.log(rezultat);
        }
    });
}

function ucitaj_podatke_o_prijatelju() {
    var id = $("select.listaProjekata").val();
    var tip = $("select.Tip").val();
    var podtip = $("select.Podtip").val();
    var idPrijatelja = $("select.listaZaduzenihPrijatelja").val();
    if(id === '' || tip === '' || podtip === '' || idPrijatelja === ''){
        return;
    }
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_status_zaduzenja_prijatelja', idProjekta: id, idPrijatelja: idPrijatelja},
        success: function(rezultat) {
            var izvestaj = rezultat.split("::");
            if(izvestaj.length == 2){
                var status = izvestaj[0];
                var napomena = izvestaj[1];

                $('#Status').val(status);
                $('#Napomena').val(napomena);
            }else{
                console.log("Javila se greška pri dohvatanju podataka o prethodnom izvestaju!");
                console.log(rezultat);
            }
            console.log("Dohvacen je prethodni izvestaj!");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o prethodnom izvestaju!");
            console.log(rezultat);
        }
    });
}

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
            $("#napisiIzvestaj").on("click", function () {

                $formaPohraniIzvestaj.fadeIn("fast");

                // Dugme za odustajanje
                $("#odustaniOdIzvestaja").on("click", function () {
                    $formaPohraniIzvestaj.fadeOut("fast");
                    $('#forma-pohraniIzvestaj')[0].reset();
                });

                // Dugme za pohranjivanje podataka za novog clana
                /*$("#forma-noviClan").on("submit", function (e) {
                 e.preventDefault();
                 })*/
            });
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju prijatelja!");
            console.log(rezultat);
        }
    });
}

/*
 * Pozivanje funkcija koje su neophodne za svaku stranicu.
 */
$(document).ready(function(){

    $formaPohraniIzvestaj = $("#formular-pohraniIzvestaj");
    $formaPohraniIzvestaj.css(stilSkrivenihFormulara);

    ucitaj_zaduzene_prijatelje();
    dohvati_imena_projekata(num_p);
});