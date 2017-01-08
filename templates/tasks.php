{% extends 'base.php' %}

{% block title %}Obaveze{% endblock %}

{% block body %}

<div class="row">
    <div class="small-12 columns">
        <h2 style="border-bottom: 1px solid #e6e6e6;">Moje obaveze</h2>
        <br>
    </div>
</div>

<div class="row">

    <div class="small-12 medium-6 large-4 columns" id="firstColumn">
        <ul class="accordion" id="firstColumnAcc" data-accordion="firstColumnAcc" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-navigation is-active" data-accordion-item="" role="presentation">
                <a href="#firstColumnData" role="tab" class="accordion-title" id="firstColumn-heading" aria-controls="firstColumnData">Neobavljene obaveze</a>
                <div id="firstColumnData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="firstColumn-heading">
                    <div class="listaObaveza"></div>
                    <button class="expanded button" id="ucitajJosObaveza">Učitaj još obaveza</button>
                </div>
            </li>
        </ul>
    </div>

    <div class="small-12 medium-6 large-4 columns" id="secondColumn">
        <ul class="accordion" id="secondColumnAcc" data-accordion="secondColumnAcc" role="tablist" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-navigation" data-accordion-item="" role="presentation">
                <a href="#secondColumnData" role="tab" class="accordion-title" id="secondColumn-heading" aria-controls="firstColumnData">Obavljene obaveze</a>
                <div id="secondColumnData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="secondColumn-heading">
                    <div class="listaZavrsenihObaveza"></div>
                </div>
            </li>
        </ul>
    </div>

    <div class="small-12 medium-6 large-4 columns" id="thirdColumn">
        <ul class="accordion" id="thirdColumnAcc" data-accordion="thirdColumnAcc" role="tablist" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-item" data-accordion-item="" role="presentation">
                {% if session['Tip'] == 'u' %}
                <a href="#thirdColumnData" class="accordion-title" role="tab"  id="thirdColumn-heading" aria-controls="thirdColumnData">Napravi novu obavezu</a>
                <div id="thirdColumnData" data-tab-content=""  class="accordion-content" role="tabpanel" aria-labelledby="thirdColumn-heading">
                    <form id="forma-novaObaveza" data-abide novalidate action="../sql/create_task.php" method="post">
                        <div data-abide-error class='alert callout' style='display: none;'>
                            <p><i class='fi-alert'></i> Postoje greške u formularu.</p>
                        </div>

                        <div class='columns'>
                            <label>
                                Naziv
                                <input type='text' id='NazivObaveze' name='NazivObaveze' required>
                            </label>
                            <label>
                                Opis
                                <textarea rows="9" cols="50" id='OpisObaveze' name='OpisObaveze' required></textarea>
                            </label>
                            <label>
                                Datum početka
                                <input type='date' id='DatumPocetkaObaveze' name='DatumPocetkaObaveze' required>
                            </label>
                            <label>Rok za završavanje obaveze
                                <input type='date' id='Deadline' name='Deadline' required>
                            </label>
                            <label>Odaberi tim
                                <select class='Tim' name='Tim' required>
                                    <option value=''></option>
                                </select>
                            </label>
                            <label>Odaberi korisnika
                                <select class="listaKorisnika" name='Korisnik' required>
                                    <option value=''></option>
                                </select>
                            </label>
                        </div>

                        <button type='submit' name='novaObaveza' id='novaObaveza' class='expanded button'>Kreiraj novu obavezu</button>

                    </form>

                </div>

                {% endif %}
            </li>
        </ul>
    </div>
</div>

<script src="../public/js/pages/tasks.js"></script>

{% endblock %}
