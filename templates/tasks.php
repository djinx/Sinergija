{% extends 'base.php' %}

{% block title %}Obaveze{% endblock %}

{% block body %}

{% set pageTitle = 'Moje obaveze' %}

{% set firstColumnTitle = 'Neobavljene obaveze' %}
{% set firstColumnData = '<div class="listaObaveza"></div>' %}
{% set firstColumnActive = true %}

{% set secondColumnTitle = 'Obavljene obaveze' %}
{% set secondColumnData = '' %}
{% set secondColumnActive = false %}

{% set thirdColumnTitle = 'Napravi novu obavezu' %}
{% set thirdColumnData = '' %}
{% set thirdColumnActive = false %}

{{ include('main_frame.html') }}

{% endblock %}
