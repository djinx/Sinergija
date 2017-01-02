<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2.1.2017
 * Time: 16:24
 */
session_start();

$_SESSION['pages']['home'] = false;
$_SESSION['pages']['projects'] = true;
$_SESSION['pages']['tasks'] = false;