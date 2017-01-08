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
        method: 'post',
        data: {num: num_p},
        success: function(rezultat){
            console.log("Dohvaćeni su projekti!");


            var $listaProjekata = $("div.listaProjekata");
            $listaProjekata.html("");
            $listaProjekata.append(rezultat);
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju projekata!");
            console.log(rezultat);
        },
        dataType: 'html'
    });
}


/**
 * Prikazuje/sakriva informacije o projektu sa zadatim identifikatorom.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * Za prikazivanje rezultata je neophodno pridružiti identifikator "informacije-Projekat" odgovarajućem <div> elementu.
 * @param idP: identifikator projekta čiji se detalji prikazuju.
 */
function procitaj_detalje_projekta(idP){
    $.ajax({
        url: "../sql/project_info.php",
        method: "post",
        data: {idP: idP},
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
 * Cita sve korisnike koji postoje u bazi podataka, a nisu ucesnici na datom projektu, u obliku:
 * <Ime> <Prezime> (<Nadimak>).
 * Dohvaceni spisak se smesta u <select> element koji ima klasu "listaClanova"
 */
function ucitaj_neucesnike(id) {
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_neucesnike', id: id},
        success: function(rezultat) {
            console.log("Dohvacena su imena clanova");
            var korisnici = rezultat.split("::");

            var $listaClanova = $("select.listaClanova");
            $listaClanova.empty();
            $listaClanova.append("<option value=''></option>");

            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $listaClanova.append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
        },
        error: function (rezultat) {
            console.log("Javila se greška pri dohvatanju podataka o clanovima!");
            console.log(rezultat);
        }
    });
}

/**
 * Dohvata sve korisnike koji učestvuju projektu sa zadatim identifikatorom, a nisu koordinatori.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaUcesnika" odgovarajućem <select> elementu.
 * @param id: identifikator projekta čiju listu učesnika treba dohvatiti.
 */
function ucitaj_ucesnike(id){
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_ucesnike', id: id},
        success: function(rezultat) {
            var korisnici = rezultat.split("::");

            var $listaUcesnika = $("select.listaUcesnika");
            $listaUcesnika.empty();
            $listaUcesnika.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $listaUcesnika.append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
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
 * Dohvata sve korisnike koji učestvuju projektu sa zadatim identifikatorom.
 * Za prikazivanje rezultata je neophodno pridružiti klasu "listaSvihUcesnika" odgovarajućem <select> elementu.
 * @param id: identifikator projekta čiju listu učesnika treba dohvatiti.
 */
function ucitaj_sve_ucesnike(id){
    $.ajax({
        url: '../sql/info.php',
        method: 'post',
        data: {akcija: 'citaj_sve_ucesnike', id: id},
        success: function(rezultat) {
            var korisnici = rezultat.split("::");

            var $listaSvihUcesnika = $("select.listaSvihUcesnika");
            $listaSvihUcesnika.empty();
            $listaSvihUcesnika.append("<option value=''></option>");
            // popunjanje select liste podacima
            for(var i=0; i<korisnici.length-1; i++){
                var korisnik = korisnici[i].split("+");
                var id = korisnik[0];
                var ime = korisnik[1];
                var prezime = korisnik[2];
                $listaSvihUcesnika.append("<option value='"+id+"'>"+ ime +" " + prezime +"</option>");
            }
            console.log("Dohvacena su imena svih ucesnika");
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
    //zahtev za popunjavanje selection liste sa clanovima koji nisu ucesnici
    ucitaj_neucesnike(id);

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
    //zahtev za popunjavanje selection liste sa ucesnicima
    ucitaj_ucesnike(id);

    $formaKoordinator.fadeIn("fast");
    $("#ProjekatIdK").val(id);

    // Dugme za odustajanje
    $("#odustaniOdKoordinatora").on("click", function () {
        $formaKoordinator.fadeOut("fast");
    });
}


/**
 * Dodaje novog prijatelja na projektu sa zadatim identifikatorom, kao i osobu zaduženu za njega.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta na kojem se dodaje novi prijatelj.
 */
function dodaj_prijatelja(id){
    //zahtev za popunjavanje selection liste sa ucenicima u projektu
    ucitaj_sve_ucesnike(id);

    //zahtev za popunjavanje selection liste sa prijateljima
    ucitaj_tipove();

    $formaDodajPrijatelja.fadeIn("fast");
    $("#ProjekatIdP").val(id);

    // Dugme za odustajanje
    $("#odustaniOdPrijatelja").on("click", function () {
        $formaDodajPrijatelja.fadeOut("fast");
    });
}

/**
 * Dodaje novu obavezu na projektu sa zadatim identifikatorom, kao i osobu zaduženu za nju.
 * Server generiše ove pozive automatski pri dohvatanju projekata.
 * @param id: identifikator projekta na kojem se dodaje novi prijatelj.
 */
function dodaj_obavezu(id){
    //ucitavanje podataka u select liste se obavlja u app.js

    $("#IdProjektaObaveza").val(id);
    $formaNovaObaveza.fadeIn("fast");

    // Dugme za odustajanje
    $("#odustaniOdNoveObaveze").on("click", function () {
        $formaNovaObaveza.fadeOut("fast");
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
        method: 'post',
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