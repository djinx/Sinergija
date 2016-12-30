<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30.12.2016
 * Time: 18:37
 */
session_start();

$_SESSION['pages'] = array();
$_SESSION['pages']['tasks'] = true;

return true;