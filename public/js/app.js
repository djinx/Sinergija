$(document).foundation();

var $formaNovUcesnik, $formaKoordinator, $formaNovPrijatelj;

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
function ucitajKorisnike() {
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_korisnike'},
        success: function(rezultat) {
            console.log("Dohvacena su imena korisnika");
            var korisnici = rezultat.split("::");
            /*
             * TODO: Dve stvari
             * 1) Promeniti tip selektora tako da dohvati samo elemente <select> koji imaju klasu "listaKorisnika"
             * 2) Refaktorisati selektor u promenljivu
             */
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

/**
 * Cita sve timove koji postoje u bazi podataka u obliku:
 * <Naziv>.
 * Dohvaceni spisak se smesta u sve <select> elemente koji imaju klasu "listaTimova"
 */
function ucitaj_timove(){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_timove'},
        success: function(rezultat) {
            console.log("Dohvaceni su nazivi timova");
            var timovi = rezultat.split("::");
            /*
             * TODO: Dve stvari
             * 1) Promeniti tip selektora tako da dohvati samo elemente <select> koji imaju klasu "listaTimova", i izmeniti sve elemente koji imaju id "TimUcesnika" i "Tim" tako da imaju klasu "listaTimova"
             * 2) Refaktorisati selektor u promenljivu
             */
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

/*
 * Pozivanje funkcija koje su neophodne za svaku stranicu.
 */
$(document).ready(function () {

    $formaNovUcesnik = $("#formular-dodajUcesnika");
    $formaKoordinator = $("#formular-dodajKoordinatora");
    $formaNovPrijatelj = $("#formular-novPrijatelj");

    $formaNovUcesnik.css(stilSkrivenihFormulara);
    $formaKoordinator.css(stilSkrivenihFormulara);
    $formaNovPrijatelj.css(stilSkrivenihFormulara);

    ucitaj_timove();
    /*
     * TODO: promeniti naziv funkcije tako da se slaze sa ostalim nazivima funkcija
     */
    ucitajKorisnike();

});



