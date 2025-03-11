<?php

$controllerName = ucwords($controller);
$controllerFile = findFile($controllerName, $baseDir = "Controllers");

if ($controllerFile && file_exists($controllerFile)) {
    require_once($controllerFile);
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $method)) {
        $controllerInstance->{$method}($params);
    } else {
        require_once("Controllers/Error.php");
    }
} else {
    require_once("Controllers/Error.php");
}
?>
