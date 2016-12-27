<html lang="sr" ng-app="application">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sinergija</title>
    <link rel="shortcut icon" href="../public/assets/favicon.png"/>
    <link rel="stylesheet" href="../public/css/foundation.css">
    <link rel="stylesheet" href="../public/css/app.css">
    {% block head %}{% endblock %}
</head>

<body>

    <div class="row">
        <div class="medium-3 columns hide-for-small-only">&nbsp;</div>
        <div class="small-12 medium-6 columns">
            <img src="../public/assets/logo.png" alt="Sinergija logo" />
            <form action="../sql/logovanje.php" method="post">
                <label>Korisničko ime
                    <input type="text" id="username" name="username" placeholder="Korisničko ime" required>
                    <span class="form-error">
                        Popunjavanje ovog polja je obavezno!
                    </span>
                </label>
                <label>Lozinka
                    <input type="password" id="password" name="password" placeholder="Lozinka" required >
                    <span class="form-error">
                        Popunjavanje ovog polja je obavezno!
                    </span>
                </label>
                <button type="submit" name="login-credentials" class="expanded button">Uloguj se</button>
            </form>
        </div>
        <div class="medium-3 columns hide-for-small-only">&nbsp;</div>
    </div>

    <script src="../public/js/vendor/jquery.js"></script>
    <script src="../public/js/vendor/what-input.js"></script>
    <script src="../public/js/vendor/foundation.js"></script>
    <script src="../public/js/app.js"></script>

</body>

</html>
