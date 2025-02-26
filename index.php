<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
    require __DIR__ . '/vendor/autoload.php';
    require_once("Config/Config.php");
    require_once("Helpers/Helpers.php");

    
    $url = !empty($_GET['url']) ? $_GET['url'] : "home/home" ;
    $arrUrl = explode("/",$url);
    $controller = $arrUrl[0];
    $method =  $arrUrl[0];
    $params = "";

    if(!empty($arrUrl[1])){
        if($arrUrl[1] != ""){
            $method = $arrUrl[1]; 
        }
    }

    if(!empty($arrUrl[2]) && $arrUrl[2] != "")
    {
        for ($i=2; $i < count($arrUrl); $i++) { 
            $params .= $arrUrl[$i].',';
        }
        $params = trim($params,",");
    }

    require_once("Libraries/Core/Autoload.php");
    require_once("Libraries/Core/Load.php");

  
?>