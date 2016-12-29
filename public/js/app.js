$(document).foundation();

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

$(document).ready(function () {

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

    podesi_photo_ikonicu();
});

$(window).resize(function () {
    podesi_photo_ikonicu();
});

$("#kreirajClana").on("click", function () {
    var formular =
        "<div id='formular-noviClan'>" +
        "       <div class='row column'>" +
        "           <form data-abide novalidate>" +
        "           <div data-abide-error class='alert callout' style='display: none;'>" +
        "               <p><i class='fi-alert'></i> Postoje greške u formularu.</p>" +
        "           </div>" +
        "               <div class='small-12 medium-6 columns'>" +
        "                   <label>Ime" +
        "                   <input type='text' id='ImeClana' name='ImeClana' required></label>" +
        "                   <label>Prezime" +
        "                   <input type='text' id='PrezimeClana' name='PrezimeClana' required></label>" +
        "                   <label>Broj telefona" +
        "                   <input type='text' id='BrojTelefonaClana' name='BrojTelefonaClana' required</label>" +
        "                   <label>Nadimak" +
        "                   <input type='text' id='NadimakClana' name='NadimakClana' required</label>" +
        "               </div>" +
        "               <div class='small-12 medium-6 columns'>" +

        "                   <label>E-mail" +
        "                   <input type='email' id='EmailClana' name='EmailClana' required></label>" +
        "                   <label>Lozinka" +
        "                   <input type='password' id='password' name='password' required></label>" +
        "                   <label>Ponovi lozinku" +
        "                   <input type='password' required data-equalto='password'></label>" +
        "                   <span class='form-error'>" +
        "                       Lozinke moraju biti jednake!" +
        "                   </span>" +
        "                   <label>Odaberite tip korisnika" +
        "                       <select id='select' required>" +
        "                           <option value=''></option>" +
        "                           <option value='c'>Član udruženja</option>" +
        "                           <option value='u'>Član upravnog odbora</option>" +
        "                       </select></label>" +
        "               </div>" +
        "               <button type='submit' name='noviClan' id='noviClan' class='expanded button'>Kreiraj novog člana</button>" +
        "               <a href='#0' id='odustani' name='odustani' class='expanded button'>Odustani</a>" +
        "           </form>" +
        "       </div>" +
        "</div>";

    // dodaje se formular u DOM
    $("#main-row").after(formular);
    var $forma = $("#formular-noviClan");
    $forma.css({
        "display": "none",
        "position": "absolute",
        "top": "40px",
        "z-index": "2",
        "background-color": "white",
        "border": "10px solid #e6e6e6",
        "border-radius": "5px",
        "width": "100%"
    });
    $forma.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustani").on("click", function () {
        $forma.fadeOut("fast", function () {
            $forma.remove();
        });
    });

    // Dugme za pohranjivanje podataka za novog clana
    $("#noviClan").on("submit", function () {

    })
});

$("#kreirajObavezu").on("click", function () {
    var formular =
        "<div id='formular-novaObaveza'>" +
        "       <div class='row column'>" +
        "           <form data-abide novalidate>" +
        "           <div data-abide-error class='alert callout' style='display: none;'>" +
        "               <p><i class='fi-alert'></i> Postoje greške u formularu.</p>" +
        "           </div>" +
        "               <div class='small-12 medium-6 columns'>" +
        "                   <label>Naziv" +
        "                   <input type='text' id='NazivObaveze' name='NazivObaveze' required></label>" +
        "                   <label>Opis" +
        "                   <input type='text' id='OpisObaveze' name='OpisObaveze' required></label>" +
        "                   <label>Datum početka" +
        "                   <input type='text' id='DatumPocetkaObaveze' name='DatumPocetkaObaveze' required</label>" +
        "               </div>" +
        "               <div class='small-12 medium-6 columns'>" +
        "                   <label>Rok za završavanje obaveze" +
        "                   <input type='text' id='Deadline' name='Deadline' required</label>" +
        "                   <label>Odaberi tim" +
        "                       <select id='Tim' required>" +
        "                           <option value=''></option>" +
        "                           <option value='1'>Logistika</option>" +
        "                           <option value='2'>PR</option>" +
        "                           <option value='3'>Neki</option>" +
        "                       </select></label>" +
        "               </div>" +
        "               <button type='submit' name='novaObaveza' id='novaObaveza' class='expanded button'>Kreiraj novu obavezu</button>" +
        "               <a href='#0' id='odustani' name='odustani' class='expanded button'>Odustani</a>" +
        "           </form>" +
        "       </div>" +
        "</div>";

    // dodaje se formular u DOM
    $("#main-row").after(formular);
    var $forma = $("#formular-novaObaveza");
    $forma.css({
        "display": "none",
        "position": "absolute",
        "top": "40px",
        "z-index": "2",
        "background-color": "white",
        "border": "10px solid #e6e6e6",
        "border-radius": "5px",
        "width": "100%"
    });
    $forma.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustani").on("click", function () {
        $forma.fadeOut("fast", function () {
            $forma.remove();
        });
    });

    // Dugme za pohranjivanje podataka za novog clana
    $("#novaObaveza").on("click", function () {
        console.log("Kreirana obaveza!");
        var naziv = document.getElementById("NazivObaveze").value;
        console.log(naziv);
        /*$.ajax({
        });*/
    })
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
