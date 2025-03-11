<?php

class Controllers {
    public $views;
    public $model;

    public function __construct() {
        $this->views = new Views();
        $this->loadModel();
    }

   public function loadModel() {
    // Obtener el nombre base de la clase (se reemplaza "Controller" por "Model")
    $modelName = str_replace('Controller', 'Model', get_class($this));
    // Buscar de forma recursiva el archivo en la carpeta Models
    $modelPath = findFile($modelName, "Models");
    
    if ($modelPath && file_exists($modelPath)) {
        require_once($modelPath);
        $this->model = new $modelName();
    }
}



}

?>