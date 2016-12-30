$(document).foundation();

var $formaNoviClan, $formaNovaObaveza;

function ucitaj(stranica) {
    $.ajax({url : '../redirect/' + stranica + '.php'});
    console.log("Vrsim redirekciju");
    window.location.reload(true);
}

$(document).ready(function () {

    $formaNoviClan = $("#formular-noviClan");
    $formaNovaObaveza = $("#formular-novaObaveza");

    $formaNoviClan.css({
        "position": "absolute",
        "top": "40px",
        "z-index": "2",
        "background-color": "white",
        "border": "10px solid #e6e6e6",
        "border-radius": "5px",
        "width": "100%"
    });
    $formaNovaObaveza.css({
        "position": "absolute",
        "top": "40px",
        "z-index": "2",
        "background-color": "white",
        "border": "10px solid #e6e6e6",
        "border-radius": "5px",
        "width": "100%"
    });

    /*$.ajax({
     url: '../sql/user_info.php',
     method: 'GET',
     data: {akcija:'prikazi_podatke'},
     success: function(rezultat){
     console.log("primljeni podaci");
     console.log(rezultat);
     var podaci = rezultat.split(">");
     var rez = "";
     var ime = podaci[1];
     var prezime = podaci[2];
     var tel = podaci[3];
     var email = podaci[4];
     var slika = podaci[5];
     var tip = podaci[6];
     rez = ime.concat(" ").concat(prezime).concat(" ");
     console.log(rez);
     $("#ime").text(rez);

     if(tip == 'u')
     $("#tip").text("Upravni odbor");
     else
     $("#tip").text("Clan");
     $("#telefon").text(tel);
     $("#email").text(email);

     document.getElementById("korisnik_slika").src = slika;

     }
     });*/

    $.ajax({
        url: '../sql/task_info.php',
        success: function(rezultat){
            console.log("Dohvaćene su obaveze!");
            $(".listaObaveza").append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju obaveza!");
            console.log(rezultat);
        },
        dataType: 'html'
    });

    //citanje naziva timova iz baze
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_timove'},
        success: function(rezultat) {
            console.log("Dohvaceni su nazivi timova");
            var timovi = rezultat.split("::");

            // popunjanje select liste podacima
            for(var i=0; i<timovi.length-1; i++){
                var tim = timovi[i].split("+");
                var id = tim[0];
                var naziv = tim[1];
                $("#Tim").append("<option value='"+id+"'>"+ naziv +" </option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju naziva timova!");
            console.log(rezultat);
        }
    });

    //citanje imena korisnika iz baze
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_korisnike'},
        success: function(rezultat) {
            console.log("Dohvacena su imena korisnika");
            var korisnici = rezultat.split("::");

            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $("#Korisnik").append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o korisnicima!");
            console.log(rezultat);
        }
    });

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