{% extends 'base.php' %}

{% block title %}Projekti{% endblock %}

{% block body %}

{% set pageTitle = 'Moji projekti' %}

{% set firstColumnTitle = 'Aktivni projekti' %}
{% set firstColumnData = '<div class="listaProjekata"></div>' %}
{% set firstColumnActive = true %}

{% set secondColumnTitle = 'Obavljene obaveze' %}
{% set secondColumnData = '' %}
{% set secondColumnActive = false %}

{% set thirdColumnTitle = 'Napravi novu obavezu' %}
{% set thirdColumnData = '' %}
{% set thirdColumnActive = false %}

{{ include('main_frame.html') }}

<script src="../public/js/pages/projects.js"></script>

{% endblock %}