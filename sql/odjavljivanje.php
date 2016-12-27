<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.12.2016
 * Time: 17:18
 */
session_start();
session_unset();
session_destroy();
header("Location:../public/");