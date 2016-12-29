<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.12.2016
 * Time: 16:14
 */
class Database
{
    private static $db = null;

    public static function getInstance(){
        if(!Database::$db){
            Database::$db = new mysqli('localhost', 'root', '', 'Sinergija');
            if(Database::$db->connect_errno){
                die("Problem sa povezivanjem!");
            }
            return Database::$db;
        }else{
            return Database::$db;
        }
    }

    private function __construct(){}

}