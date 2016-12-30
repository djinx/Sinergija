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
        <form action="../sql/odjavljivanje.php" method="post">
            <button type="submit" class="expanded button">Odjavi se</button>
        </form>

    </div>
    <div class="small-12 medium-9 columns">

        <ul class="tabs" data-tabs id="home-tabs">
            <li class="tabs-title is-active"><a href="#tab-obaveze">Obaveze</a></li>
            {% if session['Tip'] == 'u' %}
            <li class="tabs-title"><a href="#tab-administracija">Administracija</a></li>
            {% endif %}
        </ul>
        <div class="tabs-content" data-tabs-content="home-tabs">
            <div class="tabs-panel is-active" id="tab-obaveze">
                <div class="listaObaveza">

                </div>
                <button id="ucitajJos" class="expanded button" href="#0">Učitaj još</button>
            </div>
        </div>
        {% if session['Tip'] == 'u' %}
        <div class="tabs-content" data-tabs-content="home-tabs">
            <div class="tabs-panel" id="tab-administracija">
                <label>Članovi
                    <br>
                    <button type="button" class="button" name="kreirajClana" id="kreirajClana">Kreiraj novog člana</button>
                </label>
                <label>Obaveze
                    <br>
                    <button type="button" class="button" name="kreirajObavezu" id="kreirajObavezu">Kreiraj novu obavezu</button>
                </label>

            </div>
        </div>

        {% endif %}
    </div>
</div>

{{ include('create_user.html') }}

{{ include('create_task.html') }}

<script src="../public/js/pages/home.js"></script>

{% endblock %}
