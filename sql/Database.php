<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.12.2016
 * Time: 16:14
 */
class Database
{

    public static function getInstance(){

        static $db = null;

        if(!$db){
            $db = new mysqli('localhost', 'root', '', 'Sinergija');
            if($db->connect_errno){
                die("Problem sa povezivanjem!");
            }
            $db->set_charset('utf8');
        }

        return $db;
    }

    private function __construct(){}

}