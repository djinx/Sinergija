/**
 * Created by Admin on 30.12.2016.
 */

/*
 * Broj obaveza koji se dohvata u startu na ovoj stranici.
 * Vrednost je -1 ako treba dohvatiti sve obaveze.
 */
var num_o = 3;

/**
 * Dohvata sve završene obaveze iz baze podataka za prijavljenog korisnika.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaZavrsenihObaveza" odgovarajućem <div> elementu.
 */
function dohvati_obavljene_obaveze() {
    $.ajax({
        url: '../sql/all_tasks_info.php',
        success: function(rezultat){
            console.log("Dohvaćene su sve obaveze!");
            var $listaSvihObaveza = $("div.listaZavrsenihObaveza");
            $listaSvihObaveza.html("");
            $listaSvihObaveza.append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju svih obaveza!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}

/**
 * Dohvata određen broj nezavršenih obaveza iz baze podataka za prijavljenog korisnika.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaObaveza" odgovarajućem <div> elementu.
 * @param num_o: broj obaveza koji se dohvata iz baze podataka; -1 ako treba dohvatiti sve obaveze.
 */
function dohvati_neobavljene_obaveze(num_o) {
    if(num_o){
        $.ajax({
            url: '../sql/task_info.php',
            data: {num: num_o},
            success: function(rezultat){
                console.log("Dohvaćene su obaveze!");
                var $listaObaveza = $("div.listaObaveza");
                $listaObaveza.html("");
                $listaObaveza.append(rezultat);
            },
            error: function (rezultat) {
                console.log("Javila se greška pri dohvatanju obaveza!");
                console.log(rezultat);
            },
            dataType: 'html'
        });
    }
}

/**
 * Prikazuje/sakriva informacije o obavezi koje se nalaze u elementu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju obaveza.
 * @param id: identifikator elementa gde se nalaze detalji o obavezi.
 */
function procitaj_detalje_obaveze(id){
    $("#" + id).slideToggle("slow");
}

/**
 * Postavlja da prijavljeni korisnik odustaje od rada na obavezi sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju obaveza.
 * @param id: identifikator obaveze od koje se odustaje sa radom.
 */
function odustani_od_obaveze(id){
    $.ajax({
        url: "../sql/info.php",
        method: 'post',
        data: {akcija: 'odustani_od_obaveze', id: id},
        success: function() {
            console.log("Odustajanje uspesno zabelezeno");
        },
        error: function () {
            console.log("Odustajanje nije uspesno zabelezeno");
        }
    });
    dohvati_neobavljene_obaveze(num_o);
}

/**
 * Postavlja da prijavljeni korisnik završava sa radom na obavezi sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju obaveza.
 * @param id: identifikator obaveze čiji je rad završen.
 */
function zavrsi_obavezu(id){
    $.ajax({
        url: "../sql/info.php",
        method: 'post',
        data: {akcija: 'zavrsi_obavezu', id: id},
        success: function() {
            console.log("Obaveza uspesno zavrsena");
        },
        error: function () {
            console.log("Obaveza neuspesno zavrsena");
        }
    });
    dohvati_neobavljene_obaveze(num_o);
}

/*
 * Učitavanje dodatnih obaveza iz baze podataka.
 */
$("#ucitajJosObaveza").on("click", function () {
    num_o += 2;
    dohvati_neobavljene_obaveze(num_o);
});

/*
 * Pozivanje funkcija koje su neophodne za ovu stranicu.
 */
$(document).ready(function () {
    dohvati_neobavljene_obaveze(num_o);
    dohvati_obavljene_obaveze();
});