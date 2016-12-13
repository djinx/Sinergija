<?php
/**
 * Created by PhpStorm.
 * User: Buljavi Robot
 * Date: 12/13/2016
 * Time: 3:04 PM
 */

require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, array());

echo $twig->render('home.html');