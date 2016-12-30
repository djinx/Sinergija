<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.12.2016
 * Time: 18:41
 */
session_start();

unset($_SESSION['pages']);
//$_SESSION['pages'] = array();
$_SESSION['pages']['home'] = true;

return true;