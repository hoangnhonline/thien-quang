<?php 
session_start();
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);
require_once "app/config.php";

$url = $_SERVER['REQUEST_URI'];
$c = new controller($url);

function __autoload($class_name) {
   $filename = "app/class/".$class_name . '.php';	
   if (file_exists($filename)) require_once($filename); 
}//autoload

