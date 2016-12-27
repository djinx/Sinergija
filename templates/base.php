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

    <!-- Ovde ubaci titlebar i ostalo -->
    <div class="off-canvas-wrapper">
        <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
            <div class="off-canvas position-left" id="offCanvasLeft" data-off-canvas data-position="left">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Your menu or Off-canvas content goes here -->
                <ul  class="mobile-ofc vertical menu">
                    <li><a href="#">Projekti</a></li>
                    <li><a href="#">Obaveze</a></li>
                    <li><a href="#">Izloguj se</a></li>
                </ul>
            </div>

            <div class="off-canvas position-right" id="offCanvasRight" data-off-canvas data-position="right">
                <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Your menu or Off-canvas content goes here -->
                <ul  class="mobile-ofc vertical menu">
                    <li><a href="#">Dusica Krstic</a></li>
                    <li><a href="#">Nikola Pujaz</a></li>
                </ul>
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

    <script src="../public/js/vendor/jquery.js"></script>
    <script src="../public/js/vendor/what-input.js"></script>
    <script src="../public/js/vendor/foundation.js"></script>
    <script src="../public/js/app.js"></script>

</body>
</html>

