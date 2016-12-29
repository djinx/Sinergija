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
<<<<<<< HEAD
        if(!Database::$db){
            Database::$db = new mysqli('localhost', 'root', '', 'Sinergija');
            if(Database::$db->connect_errno){
=======
        static $db = null;

        if(!$db){
            $db = new mysqli('localhost', 'omikron', '123456', 'Sinergija');
            if($db->connect_errno){
>>>>>>> 9ebb4c86c66aabfe339716ff48d5731273c69944
                die("Problem sa povezivanjem!");
            }
        }

        return $db;
    }

    private function __construct(){}

}