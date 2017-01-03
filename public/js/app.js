$(document).foundation();

var $formaNoviClan, $formaNovaObaveza;
var $formaNovProjekat, $formaNovUcesik, $formaKoordinator, $formaNovPrijatelj;
var $formaBrisanjeClana;

function ucitaj(stranica) {
    $.ajax({
        url : '../redirect/' + stranica + '.php',
        success: function (rezultat) {
            //console.log(rezultat);
            window.location.assign("../public/");
        }
    });
}

//citanje imena korisnika iz baze
function ucitajKorisnike() {
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_korisnike'},
        success: function(rezultat) {
            console.log("Dohvacena su imena korisnika");
            var korisnici = rezultat.split("::");
            $(".listaKorisnika").empty();
            $(".listaKorisnika").append("<option value=''></option>");

            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $(".listaKorisnika").append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o korisnicima!");
            console.log(rezultat);
        }
    });
}

//citanje naziva timova iz baze
function ucitaj_timove(){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_timove'},
        success: function(rezultat) {
            console.log("Dohvaceni su nazivi timova");
            var timovi = rezultat.split("::");
            $("#TimUcesnika").empty();
            $("#TimUcesnika").append("<option value=''></option>");
            $("#Tim").empty();
            $("#Tim").append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<timovi.length-1; i++){
                var tim = timovi[i].split("+");
                var id = tim[0];
                var naziv = tim[1];
                $("#Tim").append("<option value='"+id+"'>"+ naziv +" </option>");
                $("#TimUcesnika").append("<option value='"+id+"'>"+ naziv +" </option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju naziva timova!");
            console.log(rezultat);
        }
    });
}

function ucitaj_ucesnike(id){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_ucesnike', id: id},
        success: function(rezultat) {
            var korisnici = rezultat.split("::");
            console.log(rezultat);
            $(".listaUcesnika").empty();
            $(".listaUcesnika").append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $(".listaUcesnika").append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
            console.log("Dohvacena su imena ucesnika");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o ucesnicima!");
            console.log(rezultat);
        }
    });
}

function ucitaj_prijatelje(){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_prijatelje'},
        success: function(rezultat) {
            var prijatelji = rezultat.split("::");
            console.log(rezultat);
            $(".listaPrijatelja").empty();
            $(".listaPrijatelja").append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<prijatelji.length-1; i++){
                var prijatelj = prijatelji[i].split("+");
                var id = prijatelj[0];
                var naziv = prijatelj[1];
                $(".listaPrijatelja").append("<option value='"+id+"'>"+ naziv +"</option>");
            }
            console.log("Dohvaceni su nazivi prijatelja");
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o prijateljima!");
            console.log(rezultat);
        }
    });

}

$(document).ready(function () {

    $formaNoviClan = $("#formular-noviClan");
    $formaNovaObaveza = $("#formular-novaObaveza");

    $formaNovProjekat = $("#formular-novProjekat");
    $formaNovUcesik = $("#formular-dodajUcesnika");
    $formaKoordinator = $("#formular-dodajKoordinatora");
    $formaNovPrijatelj = $("#formular-novPrijatelj");

    $formaBrisanjeClana = $("#formular-brisanjeClana");

    var stilSkrivenihFormulara = {
        "position": "absolute",
        "top": "40px",
        "z-index": "2",
        "background-color": "white",
        "border": "10px solid #e6e6e6",
        "border-radius": "5px",
        "width": "100%"
    };

    $formaNoviClan.css(stilSkrivenihFormulara);
    $formaNovaObaveza.css(stilSkrivenihFormulara);

    $formaNovProjekat.css(stilSkrivenihFormulara);
    $formaNovUcesik.css(stilSkrivenihFormulara);
    $formaKoordinator.css(stilSkrivenihFormulara);
    $formaNovPrijatelj.css(stilSkrivenihFormulara);

    $formaBrisanjeClana.css(stilSkrivenihFormulara);

    dohvati_projekte(num_p);
    dohvati_obaveze(num_o);

    ucitaj_timove();
    ucitajKorisnike();

    podesi_photo_ikonicu();
});

$(window).resize(function () {
    podesi_photo_ikonicu();
});

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

function dohvati_projekte(num_p) {
    $.ajax({
        url: '../sql/projects_info.php',
        data: {num: num_p},
        success: function(rezultat){
            console.log("Dohvaćeni su projekti!");
            $(".listaProjekata").html("");
            $(".listaProjekata").append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju projekata!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}

$("#ucitajJosP").on("click", function () {
    num_p += 2;
    dohvati_projekte(num_p);
});

function dohvati_obaveze(num_o) {
    $.ajax({
        url: '../sql/task_info.php',
        data: {num: num_o},
        success: function(rezultat){
            console.log("Dohvaćene su obaveze!");
            $(".listaObaveza").html("");
            $(".listaObaveza").append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju obaveza!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}

$("#ucitajJosO").on("click", function () {
    num_o += 2;
    dohvati_obaveze(num_o);
});

$("#prikazi-forma-promeniSliku").on("click", function () {
    $("#forma-promeniSliku").toggle();
});

// podesavanje efekta prelaza preko profilne slike
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

// podesavanje pozicije photo ikonice preko profilne slike
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

function zavrsi_obavezu(id){
    $.ajax({
        url: "../sql/info.php",
        data: {akcija: 'zavrsi_obavezu', id: id},
        success: function() {
            console.log("Obaveza uspesno zavrsena");
        },
        error: function () {
            console.log("Obaveza neuspesno zavrsena");
        }
    });
    dohvati_obaveze(num_o);
}

function procitaj_detalje(idP, idK){
    $.ajax({
        url: "../sql/project_info.php",
        method: "post",
        data: {idP: idP, idK: idK},
        success: function(rezultat){
            var $informacije = $("#informacije-Projekat");
            $informacije.empty();
            $informacije.css("display", "none");
            $informacije.append(rezultat);
            $informacije.slideDown("slow");
        }
    });
}

function procitaj_detalje_obaveze(id){
    $("#" + id).slideToggle("slow");
}

function odustani_od_obaveze(id){
    $.ajax({
        url: "../sql/info.php",
        data: {akcija: 'odustani_od_obaveze', id: id},
        success: function() {
            console.log("Odustajanje uspesno zabelezeno");
        },
        error: function () {
            console.log("Odustajanje nije uspesno zabelezeno");
        }
    });
    dohvati_obaveze(num_o);
}

function zavrsi_projekat(id){
    console.log(id);
    $.ajax({
        url: "../sql/info.php",
        data: {akcija: 'zavrsi_projekat', id: id},
        success: function(rezultat) {
            console.log(rezultat);
        },
        error: function () {
            console.log("Projekat neuspesno zavrsen");
        }
    });
    dohvati_projekte( num_p);
}

function dodaj_ucesnika(id) {

    $formaNovUcesik.fadeIn("fast");
    $("#ProjekatId").val(id);

    // Dugme za odustajanje
    $("#odustaniOdNovogUcesnika").on("click", function () {
        $formaNovUcesik.fadeOut("fast");
    });

    console.log("Ucesnik");
}

function dodaj_koordinatora(id) {
    //zahtev za popunjavanje selection liste sa ucenicima
    ucitaj_ucesnike(id);

    $formaKoordinator.fadeIn("fast");
    $("#ProjekatIdK").val(id);

    // Dugme za odustajanje
    $("#odustaniOdKoordinatora").on("click", function () {
        $formaKoordinator.fadeOut("fast");
    });
}


function dodaj_prijatelja(id){
    //zahtev za popunjavanje selection liste sa ucenicima u projektu
    ucitaj_ucesnike(id);

    //zahtev za popunjavanje selection liste sa prijateljima
    ucitaj_prijatelje();

    $formaNovPrijatelj.fadeIn("fast");
    $("#ProjekatIdP").val(id);

    // Dugme za odustajanje
    $("#odustaniOdPrijatelja").on("click", function () {
        $formaNovPrijatelj.fadeOut("fast");
    });
}

