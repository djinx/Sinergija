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
                </div>
            </li>
        </ul>
    </div>

    <div class="small-12 medium-6 large-4 columns" id="secondColumn">
        <ul class="accordion" id="secondColumnAcc" data-accordion="secondColumnAcc" role="tablist" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-navigation" data-accordion-item="" role="presentation">
                <a href="#secondColumnData" role="tab" class="accordion-title" id="secondColumn-heading" aria-controls="firstColumnData">Obavljene obaveze</a>
                <div id="secondColumnData" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="secondColumn-heading">
                    <div class="listaSvihObaveza"></div>
                </div>
            </li>
        </ul>
    </div>

    <div class="small-12 medium-6 large-4 columns" id="thirdColumn">
        <ul class="accordion" id="thirdColumnAcc" data-accordion="thirdColumnAcc" role="tablist" data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-item" data-accordion-item="" role="presentation">
                <a href="#thirdColumnData" class="accordion-title" role="tab"  id="thirdColumn-heading" aria-controls="thirdColumnData">Napravi novu obavezu</a>
                <div id="thirdColumnData" data-tab-content=""  class="accordion-content" role="tabpanel" aria-labelledby="thirdColumn-heading">
                </div>
            </li>
        </ul>
    </div>

</div>

<script src="../public/js/pages/tasks.js"></script>

{% endblock %}
