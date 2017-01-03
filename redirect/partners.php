<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3.1.2017
 * Time: 16:37
 */

session_start();

$_SESSION['pages']['home'] = false;
$_SESSION['pages']['partners'] = true;
$_SESSION['pages']['projects'] = false;
$_SESSION['pages']['tasks'] = false;