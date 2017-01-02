{% extends 'base.php' %}

{% block title %}Projekti{% endblock %}

{% block body %}

<div class="row">
    <div class="small-12 columns">
        <h2 style="border-bottom: 1px solid #e6e6e6;">Moji projekti</h2>
        <br>
    </div>
</div>

<div class="row">

    <div class="small-12 medium-4 large-4 columns" id="firstColumn">
        <ul class="accordion" id="firstColumnAcc" data-accordion="firstColumnAcc" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-navigation is-active" data-accordion-item="" role="presentation">
                <a href="#firstColumnData" role="tab" class="accordion-title" id="firstColumn-heading" aria-controls="firstColumnData">Aktivni projekti</a>
                <div id="firstColumnData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="firstColumn-heading">
                    <div class="listaProjekata"></div>
                </div>
            </li>
        </ul>
    </div>

    <div class="small-12 medium-8 large-8 columns" id="secondColumn">
        <div id="informacije-Projekat"></div>
    </div>

</div>

{{ include('add_user.html') }}

{{ include('add_coordinator.html') }}

{{ include('add_friend.html') }}

<script src="../public/js/pages/projects.js"></script>

{% endblock %}