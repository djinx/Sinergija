<?php

class App
{
    private $controller="home";
    private $method="index";

    private $params=[];

    public function  __construct()
    {

        $url=$this->parseUrl();

        if(file_exists("../app/contollers/".$url[0].".php")){
            $this->controller=$url[0];
            unset($url[0]);
        }

        //echo $this->controller;

        include_once "../app/contollers/".$this->controller.".php";
        $this->controller=new $this->controller;


        if(isset($url[1]) and method_exists($this->controller, $url[1])){
            $this->method=$url[1];
            unset($url[1]);
        }


        //echo $this->method;

        $this->params=$url ? array_values($url) : [];


        call_user_func([$this->controller, $this->method],$this->params);


    }

    private function parseUrl(){


        if(isset($_GET['url'])){
         return explode("/", filter_var(trim($_GET['url'], "/"), FILTER_SANITIZE_URL));

        }
    }

}