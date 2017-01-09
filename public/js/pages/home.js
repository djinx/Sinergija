/**
 * Created by Admin on 30.12.2016.
 */

/*
 * Promenljive koje cuvaju selektore formulara koji se koriste na ovoj stranici.
 */
var $formaNoviClan = $("#formular-noviClan");
var $formaBrisanjeClana = $("#formular-brisanjeClana");
//formaNovaObaveza je premestena u app.js
var $formaNovProjekat = $("#formular-novProjekat");
var $formaNoviPrijatelj = $("#formular-noviPrijatelj");
var $formaIzmenaPrijatelja = $("#formular-izmenaPrijatelja");
/*
 * Broj obaveza koji se dohvata u startu na ovoj stranici.
 * Vrednost je -1 ako treba dohvatiti sve obaveze.
 */
var num_o = 3;

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
    })
});


$("#izmeniPrijatelja").on("click", function () {

    ucitaj_tipove();
    $formaIzmenaPrijatelja.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdIzmenaPrijatelja").on("click", function () {
        $formaIzmenaPrijatelja.fadeOut("fast");
        $('#forma-izmenaPrijatelja')[0].reset();
    })
});


/*
 * Prikazuje formu za izmenu podataka o prijatelju.
*/
function prikazi_podatke_prijatelji(){
    $podaciOPrijatelju.fadeIn("fast");
    var id = $(".listaPrijatelja").val();
    // zahtev za popunjavanje podataka o odabranom prijatelju
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_podatke_prijatelji', id: id},
        success: function(rezultat) {
            // naziv, broj_telefona, email, veb_sajt, ime_kontakta, adresa
            var podaci = rezultat.split("::");

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
});