{% extends 'base.php' %}

{% block title %}Partneri{% endblock %}

{% block body %}

<div class="row">
    <div class="small-12 columns">
        <h2 style="border-bottom: 1px solid #e6e6e6;">Partneri</h2>
        <br>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <div class="listaPrijatelja">

        </div>
    </div>
</div>

{{ include('friend_report.html') }}

<script src="../public/js/pages/partners.js"></script>

{% endblock %}