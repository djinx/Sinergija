{% extends 'base.php' %}

{% block title %}Početna{% endblock %}

{% block body %}

<div class="row" id="main-row">
    <div class="medium-3 columns show-for-medium">
        <p><span class="frame alignleft"><a class="image_effect photo" href="#0"><img id="korisnik_slika" src=" {{ session['Slika'] }}"></a></span></p>
        <form  enctype="multipart/form-data"  method="post" action="../sql/upload.php" name="upload" id="upload">
            <input type="file" name="nova_slika" required>
            <input type="hidden" name="nadimak" value="{{ session['Nadimak'] }}">
            <input type="submit" name="izmeni" value="Izmeni"><br>
        </form>
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
                <div class="callout alert">
                    <h5>Završiti ponudu za robno sponzorstvo</h5>
                    <p>Deadline: 20.12.2016.</p>
                    <div class="button-group">
                        <a href="#0" class="button">Pročitaj detalje</a>
                        <a href="#0" class="button">Završi obavezu</a>
                    </div>
                </div>
                <div class="callout alert">
                    <h5>Poslati ponudu za robno sponzorstvo</h5>
                    <p>Deadline: 21.12.2016.</p>
                    <div class="button-group">
                        <a href="#0" class="button">Pročitaj detalje</a>
                        <a href="#0" class="button">Završi obavezu</a>
                    </div>
                </div>
                <div class="callout warning">
                    <h5>Pingovati kompanije za logo</h5>
                    <p>Deadline: 31.12.2016.</p>
                    <div class="button-group">
                        <a href="#0" class="button">Pročitaj detalje</a>
                        <a href="#0" class="button">Završi obavezu</a>
                    </div>
                </div>
                <a class="expanded button" href="#0">Učitaj još</a>
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
{% endblock %}
