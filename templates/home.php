{% extends 'base.php' %}

{% block title %}Početna{% endblock %}

{% block body %}

<div class="row" id="main-row">
    <div class="medium-3 columns show-for-medium">
        <p><span id="prikazi-forma-promeniSliku" class="frame alignleft"><a class="image_effect photo" href="#0"><img id="korisnik_slika" src=" {{ session['Slika'] }}"></a></span></p>
        <div id="forma-promeniSliku" style="display: none;">
            <form enctype="multipart/form-data" method="post" action="../sql/upload.php" name="upload" id="upload">
                <div class="button-group">
                    <label for="novaSlikaUpload" class="button">Odaberi fotografiju</label>
                    <input type="submit" class="button" name="izmeni" value="Izmeni"><br>
                </div>
                <input type="file" id="novaSlikaUpload" name="nova_slika" class="show-for-sr" required>
                <input type="hidden" name="nadimak" value="{{ session['Nadimak'] }}">
            </form>
        </div>
        <table>
            <tr><td id="ime"> {{ session['Ime'] ~ ' ' ~ session['Prezime'] }} </td></tr>
            <tr><td id="telefon"> {{ session['Telefon'] }}  </td></tr>
            <tr><td id="email"> {{ session['Email'] }}  </td></tr>
        </table>
        <button type="button" class="expanded button" id="promeniPodatkeClan">Promeni podatke</button>
        <button type="button" class="expanded button" id="promeniLozinkuClan">Promeni lozinku</button>
        <form action="../sql/odjavljivanje.php" method="post">
            <button type="submit" class="expanded button">Odjavi se</button>
        </form>

    </div>
    <div class="small-12 medium-9 columns">

        <ul class="tabs" data-tabs id="home-tabs">
            <li class="tabs-title"><a href="#tab-obavestenja">Obaveštenja</a></li>
            <li class="tabs-title is-active"><a href="#tab-sanduce">Sanduče</a></li>
            {% if session['Tip'] == 'u' %}
            <li class="tabs-title"><a href="#tab-administracija">Administracija</a></li>
            {% endif %}
        </ul>
        <div class="tabs-content" data-tabs-content="home-tabs">
            <div class="tabs-panel " id="tab-obavestenja">
                <div class="listaObavestenja">

                </div>
                <button id="ucitajJosObavestenja" class="expanded button">Učitaj još obaveštenja</button>
            </div>
        </div>
        <div class="tabs-content" data-tabs-content="home-tabs">
            <div class="tabs-panel is-active" id="tab-sanduce">
                <div class="row">
                    <div class="small-12 medium-4 large-4 columns" id="dugmici">
                        <button type="button" class="button" name="osveziSadrzaj" id="osveziSadrzaj">Osveži sadržaj</button>
                        <button type="button" class="button" name="posaljiNovu" id="posaljiNovu">Pošalji poruku</button>

                        <ul class="accordion" id="primljeneAcc" data-accordion="primljeneAcc" data-allow-all-closed="true" data-multi-expand="true">
                            <li class="accordion-navigation" data-accordion-item="" role="presentation">
                                <a href="#primljeneData" role="tab" class="accordion-title" id="primljene-heading" aria-controls="primljeneData">Primljene poruke</a>
                                <div id="primljeneData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="primljene-heading">
                                    <div class="primljenePoruke">

                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="accordion" id="poslateAcc" data-accordion="poslateAcc" data-allow-all-closed="true" data-multi-expand="true">
                            <li class="accordion-navigation" data-accordion-item="" role="presentation">
                                <a href="#poslateData" role="tab" class="accordion-title" id="poslate-heading" aria-controls="poslateData">Poslate poruke</a>
                                <div id="poslateData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="poslate-heading">
                                    <div class="poslatePoruke">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="small-12 medium-8 large-8 columns">
                        <div id="formular-novaPoruka" style='display: none;'>
                            <form id="forma-novaPoruka" data-abide novalidate>
                                <label>
                                    Primalac
                                    <select id="primalac" class="listaKorisnika" name='Korisnik' required>
                                        <option value=''></option>
                                    </select>
                                </label>
                                <label>
                                    Naslov poruke
                                    <input type='text' id='naslovPoruke' name='naslovPoruke' >
                                </label>
                                <label> Poruka
                                    <textarea id="tekstPoruke" name="tekstPoruke" rows="10" cols="5" required></textarea>
                                </label>

                                <button type='button' name='posaljiPoruku' id='posaljiPoruku' class='expanded button'>Pošalji</button>
                                <a href='#0' id='odustaniOdNovePoruke' class='expanded button'>Odustani</a>
                            </form>
                        </div>
                        <div id="prikazPoruke">
                            <button type="button" class="close-button" id="zatvoriPoruku">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <label> Naslov:
                                <span id="naslov"></span>
                            </label>
                            <label> Pošiljalac:
                                <span id="posiljaoc"></span>
                            </label>
                            <label> Primalac:
                                <span id="primalac"></span>
                            </label>
                            <label> Vreme:
                                <span id="vreme"></span>
                            </label>
                            <p id="tekst"></p>
                            <div  class="wrapper" style="display: none;">
                                <img src="../public/assets/checkmark.png" class="read" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {% if session['Tip'] == 'u' %}
        <div class="tabs-content" data-tabs-content="home-tabs">
            <div class="tabs-panel" id="tab-administracija">
                <label>Članovi
                    <br>
                    <div class="button-group">
                        <button type="button" class="button" name="kreirajClana" id="kreirajClana">Kreiraj novog člana</button>
                        <button type="button" class="button" name="obrisiClana" id="obrisiClana">Obriši člana</button>
                    </div>
                </label>
                <label>Obaveze
                    <br>
                    <button type="button" class="button" name="kreirajObavezu" id="kreirajObavezu">Kreiraj novu obavezu</button>
                </label>
                <label>Projekti
                    <br>
                    <button type="button" class="button" name="kreirajProjekat" id="kreirajProjekat">Kreiraj nov projekat</button>
                </label>
                <label>Prijatelji
                    <br>
                    <div class="button-group">
                        <button type="button" class="button" name="kreirajPrijatelja" id="kreirajPrijatelja">Kreiraj novog prijatelja</button>
                        <button type="button" class="button" name="izmeniPrijatelja" id="izmeniPrijatelja">Izmeni</button>
                    </div>
                </label>

            </div>
        </div>

        {% endif %}
    </div>
</div>

{{ include('create_user.html') }}

{{ include('update_user.html') }}

{{ include('update_password.html') }}

{{ include('create_task.html') }}

{{ include('create_project.html') }}

{{ include('obrisi_korisnika.html') }}

{{ include('create_friend.html') }}

{{ include('update_friend.html') }}

<script src="../public/js/pages/home.js"></script>

{% endblock %}
