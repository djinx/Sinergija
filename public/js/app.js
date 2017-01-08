$(document).foundation();

var $formaNovUcesnik, $formaKoordinator, $formaDodajPrijatelja, $formaNovaObaveza;

var $podaciOPrijatelju;

/*
 * CSS stil u JSON formatu koji se koristi za predstavljanje izgleda formulara nakon njihovog prikaza.
 */
var stilSkrivenihFormulara = {
    "position": "absolute",
    "top": "40px",
    "z-index": "2",
    "background-color": "white",
    "border": "10px solid #e6e6e6",
    "border-radius": "5px",
    "width": "100%"
};

/**
 * Ucitava skript za preusmeravanje na odgovarajucu stranicu. Koristi se u pozivu klika na dugmadi u glavnom meniju.
 * @param naziv: stranica na koju treba izvrsiti redirekciju
 */
function ucitaj_stranicu(naziv) {
    $.ajax({
        url : '../redirect/' + naziv + '.php',
        method: 'post',
        success: function () {
            window.location.assign("../public/");
        }
    });
}

/**
 * Cita sve korisnike koji postoje u bazi podataka u obliku:
 * <Ime> <Prezime> (<Nadimak>).
 * Dohvaceni spisak se smesta u sve <select> elemente koji imaju klasu "listaKorisnika"
 */
function ucitaj_korisnike() {
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_korisnike'},
        success: function(rezultat) {
            console.log("Dohvacena su imena korisnika");
            var korisnici = rezultat.split("::");

            var $listaKorisnika = $("select.listaKorisnika");
            $listaKorisnika.empty();
            $listaKorisnika.append("<option value=''></option>");

            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $listaKorisnika.append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o korisnicima!");
            console.log(rezultat);
        }
    });
}

/**
 * Cita sve timove koji postoje u bazi podataka u obliku:
 * <Naziv>.
 * Dohvaceni spisak se smesta u sve <select> elemente koji imaju klasu "listaTimova"
 */
function ucitaj_timove(){
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_timove'},
        success: function(rezultat) {
            console.log("Dohvaceni su nazivi timova");
            var timovi = rezultat.split("::");


            var $tim = $("select.Tim");
            var $timUcesnika = $("select.TimUcesnika");
            $timUcesnika.empty();
            $timUcesnika.append("<option value=''></option>");
            $tim.empty();
            $tim.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<timovi.length-1; i++){
                var tim = timovi[i].split("+");
                var id = tim[0];
                var naziv = tim[1];
                $tim.append("<option value='"+id+"'>"+ naziv +" </option>");
                $timUcesnika.append("<option value='"+id+"'>"+ naziv +" </option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju naziva timova!");
            console.log(rezultat);
        }
    });
}


/**
 * Dohvata sve tipove koji postoje u bazi podatka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "Tip" odgovarajucem <select> elementu.
 */

function ucitaj_tipove(){
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

function ucitaj_podtipove(){
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

    // brisemo sadrzaj liste prijatelja jer je potrebno odabrati nov podtip
    var $listaPrijatelja =  $("select.listaPrijatelja");
    $listaPrijatelja.empty();
    $listaPrijatelja.append("<option value=''></option>");

    $podaciOPrijatelju.fadeOut("fast");
}

/**
 * Dohvata prijatelje sa zadatim tipom i podtipom koji postoje u bazi podataka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaPrijatelja" odgovarajućem <select> elementu.
 */
function ucitaj_prijatelje(){
    var tip = $(".Tip").val();
    var podtip = $(".Podtip").val();

    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_prijatelje', tip: tip, podtip: podtip},
        success: function(rezultat) {
            var prijatelji = rezultat.split("::");

            var $listaPrijatelja =  $("select.listaPrijatelja");
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

/*
 * Pozivanje funkcija koje su neophodne za svaku stranicu.
 */
$(document).ready(function () {

    $formaNovUcesnik = $("#formular-dodajUcesnika");
    $formaKoordinator = $("#formular-dodajKoordinatora");
    $formaDodajPrijatelja = $("#formular-dodajPrijatelja");
    $formaNovaObaveza = $("#formular-novaObaveza");
    $podaciOPrijatelju = $("#podaciOPrijatelju");

    $formaNovUcesnik.css(stilSkrivenihFormulara);
    $formaKoordinator.css(stilSkrivenihFormulara);
    $formaDodajPrijatelja.css(stilSkrivenihFormulara);
    $formaNovaObaveza.css(stilSkrivenihFormulara);

    ucitaj_timove();
    ucitaj_korisnike();

});



