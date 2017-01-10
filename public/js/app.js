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



