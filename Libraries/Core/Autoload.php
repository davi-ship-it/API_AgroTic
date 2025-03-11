<?php
    spl_autoload_register(function($class){
    // Define las carpetas donde buscar
    $paths = [
        'Libraries/Core/',
        'Models/',
        'Controllers',

    ];
    
    // Busca en cada carpeta
    foreach($paths as $path) {
        $file = $path.$class.".php";
        if(file_exists($file)){
            require_once($file);
            return;
        }
    }
});
?>