$(document).foundation();

$(document).ready(function(){
    console.log("spreman");
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
});

