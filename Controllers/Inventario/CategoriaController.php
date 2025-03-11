<?php
class CategoriaController extends Controllers {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Registrar una nueva categoría
    public function registrarCategoria() {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);
            
            // Validar que el dato exista y sea válido
            if(empty($_POST['cat_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la categoría es obligatorio"], 400);
                return;
            }
            if(!testString($_POST['cat_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la categoría es inválido"], 400);
                return;
            }
            
            $resultado = $this->model->registrarCategoria($_POST['cat_nombre']);
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al registrar la categoría: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener todas las categorías
    public function obtenerTodos() {
        try {
            $resultado = $this->model->obtenerTodasCategorias();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener categorías: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener una categoría por ID
    public function obtenerPorId($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->obtenerPorIdCategoria($id);
            if($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Categoría no encontrada"], 404);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener la categoría: " . $e->getMessage()], 500);
        }
    }
    
    // Actualizar una categoría
    public function actualizarCategoria($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $_POST = json_decode(file_get_contents("php://input"), true);
            if(empty($_POST['cat_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la categoría es obligatorio"], 400);
                return;
            }
            if(!testString($_POST['cat_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la categoría es inválido"], 400);
                return;
            }
            
            $resultado = $this->model->actualizarCategoria($id, $_POST['cat_nombre']);
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar la categoría: " . $e->getMessage()], 500);
        }
    }
    
    // Eliminar una categoría
    public function eliminarCategoria($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->eliminarCategoria($id);
            if($resultado) {
                jsonResponse(["status" => true, "msg" => "Categoría eliminada correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar la categoría"], 400);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar la categoría: " . $e->getMessage()], 500);
        }
    }
}
?>
