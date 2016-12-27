<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/13/2016
 * Time: 3:04 PM
 */
session_start();

require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, array());

if(isset($_SESSION['bad_password'])){
    echo $twig->render('bad_password.php');
    session_unset();
    session_destroy();
}else{
    if(isset($_SESSION['username']['idKorisnika'])){
        echo $twig->render('home.php');
    }else{
        echo $twig->render('login.php');
        session_unset();
        session_destroy();
    }
}