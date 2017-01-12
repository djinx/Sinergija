<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="sr" ng-app="application">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{% block title %}{% endblock %} - Sinergija</title>
	<link rel="shortcut icon" href="../public/assets/favicon.png"/>
    <link rel="stylesheet" href="../public/css/foundation.css">
    <link rel="stylesheet" href="../public/css/app.css">
    {% block head %}{% endblock %}
</head>

<body>

    <script src="../public/js/vendor/jquery.js"></script>
    <script src="../public/js/vendor/what-input.js"></script>

    <!-- Ovde ubaci titlebar i ostalo -->
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas data-position="left">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Your menu or Off-canvas content goes here -->
                <ul class="mobile-ofc vertical menu">
                    <li><button class="expanded button" id="pocetnaLink" onclick="ucitaj_stranicu('home')">Početna</button></li>
                    <li><button class="expanded button" id="obavezeLink" onclick="ucitaj_stranicu('tasks')">Obaveze</button></li>
                    <li><button class="expanded button" id="projektiLink" onclick="ucitaj_stranicu('projects')">Projekti</button></li>
                    <li><button class="expanded button" id="partneriLink" onclick="ucitaj_stranicu('partners')">Partneri</button></li>
                    <li>
                        <form action="../sql/odjavljivanje.php" method="post">
                            <button type="submit" class="expanded button">Odjavi se</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="off-canvas position-right" id="offCanvasRight" data-off-canvas data-position="right">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Off-canvas content goes here -->
				<a href="../templates/chat.php" target="_blank">Grupno ćaskanje</a>
            </div>
        </div>
    </div>

    <div class="title-bar">
        <div class="title-bar-left">
            <button class="menu-icon" type="button" data-toggle="offCanvasLeft"></button>
            <span class="title-bar-title">Sinergija</span>
        </div>
        <div class="title-bar-right">
            <button class="menu-icon" type="button" data-toggle="offCanvasRight"></button>
        </div>
    </div>

    {% block body %}{% endblock %}

    <script src="../public/js/vendor/foundation.js"></script>
    <script src="../public/js/app.js"></script>

</body>
</html>

