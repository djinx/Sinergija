{% extends 'base.php' %}

{% block title %}Obaveze{% endblock %}

{% block body %}

{% set pageTitle = 'Moje obaveze' %}

{% set firstColumnTitle = 'Neobavljene obaveze' %}
{% set firstColumnData = '' %}

{% set secondColumnTitle = 'Sve obaveze' %}
{% set secondColumnData = '' %}

{% set thirdColumnTitle = 'Napravi novu obavezu' %}
{% set thirdColumnData = '' %}

{{ include('main_frame.html') }}

{% endblock %}
