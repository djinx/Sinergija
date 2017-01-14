/**
 * Created by Admin on 30.12.2016.
 */

/*
 * Promenljive koje cuvaju selektore formulara koji se koriste na ovoj stranici.
 */
var $formaNoviClan = $("#formular-noviClan");
var $formaBrisanjeClana = $("#formular-brisanjeClana");

var $formaNovProjekat = $("#formular-novProjekat");
var $formaNoviPrijatelj = $("#formular-noviPrijatelj");
var $formaIzmenaPrijatelja = $("#formular-izmenaPrijatelja");
var $podaciOPrijatelju = $("#podaciOPrijatelju");

var $formaNovaPoruka = $("#formular-novaPoruka");
var $prikazPoruke = $("#prikazPoruke");

/*
 * Broj obaveštenja koji se dohvata u startu na ovoj stranici.
 */
var num_obav = 3;

/**
 * Podesavanje velicine i pozicije photo ikonice koja se nalazi preko profilne slike.
 */
function podesi_photo_ikonicu() {
    var hover_slicice = $("a.image_effect");

    hover_slicice.each(function () {

        var sirina_slike = $(this).find('img').innerWidth();
        var visina_slike = $(this).find('img').innerHeight();
        var klasa_slike = $(this).attr("class");
        $(this).prepend('<span class="imagemask ' + klasa_slike + '"></span>');

        var slika = $(this).find('img');
        var pozicija = slika.position();
        var poz_top = parseInt(slika.css("margin-top")) + pozicija.top;
        var poz_left = parseInt(slika.css("margin-left")) + pozicija.left;
        if (!poz_left) {
            poz_left = pozicija.left
        }

        $(this).find('.imagemask').css("top", poz_top);
        $(this).find('.imagemask').css("left", poz_left);

        $('.imagemask', this).css({
            "width":sirina_slike,
            "height":visina_slike,
            "backgroundPosition":"center center"
        });

    });
}

/*
 * U slucaju promene velicine prozora, treba ponovo preracunati velicinu i poziciju photo ikonice.
 */
$(window).resize(function () {
    podesi_photo_ikonicu();
});

/*
 * Prikazivanje/sakrivanje opcije za promenu profilne slike.
 */
$("#prikazi-forma-promeniSliku").on("click", function () {
    $("#forma-promeniSliku").toggle();
});

/*
 * Podesavanje efekta prelaza preko profilne slike.
 */
var efekat_slike = $("a.image_effect");
efekat_slike.mouseover(function () {
    $(this).find('.imagemask').stop().animate({
        "display":"block",
        "opacity":"1",
        "z-index":"400"
    }, 100);
    $(this).find('img').stop().animate({
        "opacity":"0.7"
    }, 200);
}).mouseout(function () {
    $(this).find('.imagemask').stop().animate({
        "display":"none",
        "opacity":"0",
        "z-index":"0"
    }, 100);
    $(this).find('img').stop().animate({
        "opacity":"1"
    }, 300);
});

/*
 * Naredne funkcije definisu prikazivanje/sakrivanje formulara klikom na odgovarajucu dugmad
 */
$("#kreirajClana").on("click", function () {

    $formaNoviClan.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdNovogClana").on("click", function () {
        $formaNoviClan.fadeOut("fast");
        $('#forma-noviClan')[0].reset();
    });

    // Dugme za pohranjivanje podataka za novog clana
    /*$("#forma-noviClan").on("submit", function (e) {
     e.preventDefault();
     })*/
});

$("#obrisiClana").on("click", function () {

    $formaBrisanjeClana.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdBrisanjaClana").on("click", function () {
        $formaBrisanjeClana.fadeOut("fast");
        $('#forma-brisanjeClana')[0].reset();
    });

    // Dugme za pohranjivanje podataka za novog clana
    /*$("#forma-noviClan").on("submit", function (e) {
     e.preventDefault();
     })*/
});

$("#kreirajObavezu").on("click", function () {

    $formaNovaObaveza.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdNoveObaveze").on("click", function () {
        $formaNovaObaveza.fadeOut("fast");
        $('#forma-novaObaveza')[0].reset();
    });

    // Dugme za pohranjivanje podataka za novu obavezu
    /*$("#novaObaveza").on("click", function (e) {
     e.preventDefault();
     console.log("Kreirana obaveza!");
     var naziv = document.getElementById("NazivObaveze").value;
     console.log(naziv);
     $.ajax({
     });
     })*/
});

$("#kreirajProjekat").on("click", function () {

    $formaNovProjekat.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdNovogProjekta").on("click", function () {
        $formaNovProjekat.fadeOut("fast");
        $('#forma-novProjekat')[0].reset();
    });

    // Dugme za pohranjivanje podataka za novu obavezu
    /*$("#novaObaveza").on("click", function (e) {
     e.preventDefault();
     $.ajax({
     });
     })*/
});


$("#kreirajPrijatelja").on("click", function () {
    $formaNoviPrijatelj.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdNovogPrijatelja").on("click", function () {
        $formaNoviPrijatelj.fadeOut("fast");
        $('#forma-noviPrijatelj')[0].reset();
    })
});


$("#izmeniPrijatelja").on("click", function () {

    ucitaj_tipove_svih();
    $formaIzmenaPrijatelja.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdIzmenaPrijatelja").on("click", function () {
        $formaIzmenaPrijatelja.fadeOut("fast");
        $('#forma-izmenaPrijatelja')[0].reset();
    })
});


/**
 * Dohvata sve tipove koji postoje u bazi podatka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "Tip" odgovarajucem <select> elementu.
 */

function ucitaj_tipove_svih(){
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_tipove'},
        success: function(rezultat) {
            var tipovi = rezultat.split("::");

            var $tip =  $("select.Tip");
            $tip.empty();
            $tip.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<tipovi.length-1; i++){
                $tip.append("<option value='"+tipovi[i]+"'>"+ tipovi[i] +"</option>");
            }
            console.log("Dohvaceni su tipovi prijatelja");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o tipovima prijatelja!");
            console.log(rezultat);
        }

    });

    $podaciOPrijatelju.fadeOut("fast");
}

/**
 * Dohvata sve podtipove, za odabrani tip, koji postoje u bazi podatka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "Tip" odgovarajucem <select> elementu.
 */

function ucitaj_podtipove_svih(){

    // brisemo sadrzaj svih trenutnih vrednosti
    var $listaPrijatelja =  $("select.listaSvihPrijatelja");
    $listaPrijatelja.empty();
    $listaPrijatelja.append("<option value=''></option>");
    $podaciOPrijatelju.fadeOut("fast");
    $podaciOPrijatelju.find('input').val('');
    $listaPrijatelja.val('');
    $(".Podtip").val('');


    var tip = $(".Tip").val();
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_podtipove', tip: tip},
        success: function(rezultat) {
            var podtipovi = rezultat.split("::");

            var $podtip =  $("select.Podtip");
            $podtip.empty();
            $podtip.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<podtipovi.length-1; i++){
                $podtip.append("<option value='"+podtipovi[i]+"'>"+ podtipovi[i] +"</option>");
            }
            console.log("Dohvaceni su podtipovi prijatelja");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o tipovima prijatelja!");
            console.log(rezultat);
        }

    });
}


/**
 * Dohvata prijatelje sa zadatim tipom i podtipom koji postoje u bazi podataka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaPrijatelja" odgovarajućem <select> elementu.
 */
function ucitaj_sve_prijatelje(){

    // brisemo sadrzaj svih trenutnih vrednosti
    $(".listaSvihPrijatelja").val('');
    // sklanjamo polja sa podacima ukoliko su prikazana
    $podaciOPrijatelju.fadeOut("fast");
    $podaciOPrijatelju.find('input').val('');

    var tip = $(".Tip").val();
    var podtip = $(".Podtip").val();

    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_sve_prijatelje', tip: tip, podtip: podtip},
        success: function(rezultat) {
            var prijatelji = rezultat.split("::");

            var $listaPrijatelja =  $("select.listaSvihPrijatelja");
            $listaPrijatelja.empty();
            $listaPrijatelja.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<prijatelji.length-1; i++){
                var prijatelj = prijatelji[i].split("+");
                var id = prijatelj[0];
                var naziv = prijatelj[1];
                $listaPrijatelja.append("<option value='"+id+"'>"+ naziv +"</option>");
            }
            console.log("Dohvaceni su nazivi prijatelja");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o prijateljima!");
            console.log(rezultat);
        }
    });

}


/**
 * Prikazuje formu za izmenu podataka o prijatelju.
 */
function prikazi_podatke_prijatelji(){
    // brisemo podatke koji su vec upisani i ispisujemo podatke iz baze
    $podaciOPrijatelju.find('input').val('');
    $podaciOPrijatelju.fadeIn("fast");

    var id = $(".listaSvihPrijatelja").val();
    // zahtev za popunjavanje podataka o odabranom prijatelju
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_podatke_prijatelji', id: id},
        success: function(rezultat) {
            // naziv, broj_telefona, email, veb_sajt, ime_kontakta, adresa
            var podaci = rezultat.split("::");
            console.log(rezultat);
            $("#BrojTelefonaPrijatelja1").val(podaci[1]);
            $("#EmailPrijatelja1").val(podaci[2]);
            $("#VebSajtPrijatelja1").val(podaci[3]);
            $("#ImeKontaktaPrijatelja1").val(podaci[4]);
            $("#AdresaPrijatelja1").val(podaci[5]);

            console.log("Dohvaceni su podaci o  prijateljima");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o prijateljima!");
            console.log(rezultat);
        }
    });

}

/**
 * Učitava dodatna obaveštenja iz baze podataka.
 */
function ucitaj_obavestenja() {
    $.ajax({
        url: '../sql/obavestenja.php',
        method: 'post',
        data: {num: num_obav},
        success: function (rezultat) {
            console.log("Dohvacena su obavestenja");
            $obavestenja = $("div.listaObavestenja");
            $obavestenja.empty();
            $obavestenja.append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju obaveštenja!");
            console.log(rezultat);
        }
    });
}

/*
 * Povećava broj obaveštenja koja se dohvataju i dohvata ih.
 */
$("#ucitajJosObavestenja").on('click', function () {
    num_obav += 3;
    ucitaj_obavestenja();
});

/*
 * Zatvara sve otvorene forme i brise njihov sadrzaj
 * i ucitava poslate i primljene poruke
 */
$("#osveziSadrzaj").on('click', function () {
    $formaNovaPoruka.fadeOut("fast");
    $('#forma-novaPoruka')[0].reset();
    $prikazPoruke.fadeOut("fast");
    dohvati_primljene();
    dohvati_poslate();
});

/*
 * Otvara formu za slanje nove poruke
 */
$("#posaljiNovu").on('click', function(){
    $formaNovaPoruka.fadeIn("fast");
    $prikazPoruke.fadeOut("fast");

    $("#odustaniOdNovePoruke").on('click', function () {
        $formaNovaPoruka.fadeOut("fast");
        $('#forma-novaPoruka')[0].reset();
    });
});

/*
 * Dohvata sve poruke koje je primio ulogovan korisnik.
 */
function dohvati_primljene(){
    // podatak akcija: 'citaj_primljene'
    $.ajax({
        url: '../sql/info.php',
        data: {akcija: 'citaj_primljene'},
        method: 'post',
        success: function(rezultat) {
            var $listaPrimljenih =  $("div.primljenePoruke");
            $listaPrimljenih.empty();
            $listaPrimljenih.append(rezultat);
            console.log("Dohvacene su poruke");
            //console.log(rezultat);
            $listaPrimljenih.foundation();
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju poruka!");
            console.log(rezultat);
        }
    });

}

/*
 * Dohvata sve poruke koje je poslao ulogovan korisnik
 */
function dohvati_poslate(){
    // podatak akcija: 'citaj_poslate'
    $.ajax({
        url: '../sql/info.php',
        data: {akcija: 'citaj_poslate'},
        method: 'post',
        success: function(rezultat) {
            var $listaPrimljenih =  $("div.poslatePoruke");
            $listaPrimljenih.empty();
            $listaPrimljenih.append(rezultat);
            console.log("Dohvacene su poruke");
            //console.log(rezultat);
            $listaPrimljenih.foundation();
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju poruka!");
            console.log(rezultat);
        }
    });
}

/*
 * Prikazuje podatke o poruci.
 */
function prikazi_poruku(){
    $formaNovaPoruka.fadeOut("fast");
    $prikazPoruke.fadeIn("fast");

    // TODO: procitati sva polja iz diva
}

/*
 * Pozivanje funkcija koje su neophodne za ovu stranicu.
 */
$(document).ready(function () {

    $formaNoviClan.css(stilSkrivenihFormulara);
    $formaBrisanjeClana.css(stilSkrivenihFormulara);

    $formaNovProjekat.css(stilSkrivenihFormulara);
    $formaNoviPrijatelj.css(stilSkrivenihFormulara);
    $formaIzmenaPrijatelja.css(stilSkrivenihFormulara);

    podesi_photo_ikonicu();
    ucitaj_obavestenja();
    dohvati_primljene();
    dohvati_poslate();
});