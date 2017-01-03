/**
 * Created by Admin on 2.1.2017.
 */

/*
 * Broj projekata koji se dohvata u startu na ovoj stranici.
 * Vrednost je -1 ako treba dohvatiti sve projekte.
 */
var num_p = -1;

/**
 * Dohvata određen broj svih nezavršenih (aktivnih) projekata iz baze podataka na kojima prijavljeni korisnik učestvuje.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaProjekata" odgovarajućem <div> elementu.
 * @param num_p: broj projekata koji se dohvata iz baze podataka; -1 ako treba dohvatiti sve projekte.
 */
function dohvati_projekte(num_p) {
    $.ajax({
        url: '../sql/projects_info.php',
        data: {num: num_p},
        success: function(rezultat){
            console.log("Dohvaćeni su projekti!");
            /*
             * TODO: refaktorisati selektor u promenljivu
             */
            $("div.listaProjekata").html("");
            $("div.listaProjekata").append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju projekata!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}

/*
 * TODO: refaktorisati u procitaj_detalje_projekta i izbaciti drugi argument (iz kodova i iz komentara ispod)
 */
/**
 * Prikazuje/sakriva informacije o projektu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * Za prikazivanje rezultata je neophodno pridružiti identifikator "informacije-Projekat" odgovarajućem <div> elementu.
 * @param idP: identifikator projekta čiji se detalji prikazuju.
 * @param idK: identifikator korisnika čiji se projekti prikazuju.
 */
function procitaj_detalje(idP, idK){
    $.ajax({
        url: "../sql/project_info.php",
        method: "post",
        data: {idP: idP, idK: idK},
        success: function(rezultat){
            var $informacije = $("div#informacije-Projekat");
            $informacije.empty();
            $informacije.css("display", "none");
            $informacije.append(rezultat);
            $informacije.slideDown("slow");
        }
    });
}

/**
 * Dohvata sve korisnike koji učestvuju projektu sa zadatim identifikatorom.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaUcesnika" odgovarajućem <select> elementu.
 * @param id: identifikator projekta čiju listu učesnika treba dohvatiti.
 */
function ucitaj_ucesnike(id){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_ucesnike', id: id},
        success: function(rezultat) {
            var korisnici = rezultat.split("::");
            console.log(rezultat);
            /*
             * TODO: Dve stvari
             * 1) Promeniti tip selektora tako da dohvati samo elemente <select> koji imaju klasu "listaUcesnika"
             * 2) Refaktorisati selektor u promenljivu
             */
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

/**
 * Dodaje novog učesnika u određeni tim na projektu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta na kojem se dodaje novi učesnik.
 */
function dodaj_ucesnika(id) {
    $formaNovUcesnik.fadeIn("fast");
    $("#ProjekatId").val(id);

    // Dugme za odustajanje
    $("#odustaniOdNovogUcesnika").on("click", function () {
        $formaNovUcesnik.fadeOut("fast");
    });
}

/**
 * Dodaje novog koordinatora određenog tima na projektu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta na kojem se dodaje novi koordinator.
 */
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

/**
 * Dohvata prijatelje koji postoje u bazi podataka.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaPrijatelja" odgovarajućem <select> elementu.
 */
function ucitaj_prijatelje(){
    $.ajax({
        url: '../sql/info.php',
        method: 'GET',
        data: {akcija: 'citaj_prijatelje'},
        success: function(rezultat) {
            var prijatelji = rezultat.split("::");
            console.log(rezultat);
            /*
             * TODO: Dve stvari
             * 1) Promeniti tip selektora tako da dohvati samo elemente <select> koji imaju klasu "listaPrijatelja"
             * 2) Refaktorisati selektor u promenljivu
             */
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

/**
 * Dodaje novog prijatelja na projektu sa zadatim identifikatorom, kao i osobu zaduženu za njega.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta na kojem se dodaje novi prijatelj.
 */
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

/**
 * Postavlja da se završava sa radom na projektu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta čiji je rad završen.
 */
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
    dohvati_projekte(num_p);
}

/*
 * Pozivanje funkcija koje su neophodne za ovu stranicu.
 */
$(document).ready(function () {
    dohvati_projekte(num_p);
});