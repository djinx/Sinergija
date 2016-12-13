<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/13/2016
 * Time: 2:39 PM
 */
?>
<html lang="sr" ng-app="application">

<head>
    {% block head %}

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{% block title %}{% endblock %} - Sinergija</title>
    <link href="assets/css/app.css" rel="stylesheet" type="text/css">
    <script src="assets/js/app.js"></script>
    <script src="assets/js/routes.js"></script>
    <script src="assets/js/angular.js"></script>

    {% end block %}
</head>

<body>

    <div class="grid-frame vertical">

        <div class="dark shrink title-bar">
            <div class="center title">Productivity</div>
            <span class="left"><a zf-open="projects">Projects</a></span>
            <span class="right"><a zf-open="profile">Profile</a></span>
        </div>

        <div class="grid-content shrink collapse">
            <ul class="primary icon-left condense menu-bar">
                <li><a href="#"><img src="http://placehold.it/50x50"><strong>Foundation for Apps</strong></a></li>
            </ul>
        </div>
        <div class="grid-block scroll-section" ng-class="['ui-animation']" ui-view>
        </div>
    </div>

    <zf-panel id="projects" position="left">
        <a href="#" zf-close>&times;</a>
        <ul class="menu-bar vertical">
            <li>
                <a href="#">
                    <img src="http://placehold.it/50x50">
                    <span class="block-list-label">Amazing Project  &#x2730;</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="http://placehold.it/50x50">
                    <span class="block-list-label">Amazing Project  &#x2730;</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="http://placehold.it/50x50">
                    <span class="block-list-label">Amazing Project  &#x2730;</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="http://placehold.it/50x50">
                    <span class="block-list-label">Amazing Project  &#x2730;</span>
                </a>
            </li>
        </ul>
    </zf-panel>

    <zf-panel id="profile" position="right">
        <div class="grid-content small-12">
            <a href="#" zf-close>&times;</a>
            <section class="block-list">
                <header>Activity</header>
                <ul>
                    <li class="with-chevron">
                        <a href="#">
                            <img src="http://placehold.it/50x50">
                            <span class="block-list-label">Jarvis moved a file</span>
                        </a>
                    </li>
                    <li class="with-chevron">
                        <a href="#">
                            <img src="http://placehold.it/50x50">
                            <span class="block-list-label">Jarvis moved a file</span>
                        </a>
                    </li>
                    <li class="with-chevron">
                        <a href="#">
                            <img src="http://placehold.it/50x50">
                            <span class="block-list-label">Jarvis moved a file</span>
                        </a>
                    </li>
                    <li class="with-chevron">
                        <a href="#">
                            <img src="http://placehold.it/50x50">
                            <span class="block-list-label">Jarvis moved a file</span>
                        </a>
                    </li>
                    <li class="with-chevron">
                        <a href="#">
                            <img src="http://placehold.it/50x50">
                            <span class="block-list-label">Jarvis moved a file</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </zf-panel>
</body>
</html>

