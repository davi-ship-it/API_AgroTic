<?php
class BodegaController extends Controllers {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Registrar una nueva bodega
    public function registrarBodega() {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);
            
            if(empty($_POST['bod_numero'])) {
                jsonResponse(["status" => false, "msg" => "El número de la bodega es obligatorio"], 400);
                return;
            }
            if(empty($_POST['bod_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la bodega es obligatorio"], 400);
                return;
            }
            if(!testEntero($_POST['bod_numero'])) {
                jsonResponse(["status" => false, "msg" => "El número de la bodega es inválido"], 400);
                return;
            }
            if(testString($_POST['bod_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la bodega es inválido"], 400);
                return;
            }
            
            $resultado = $this->model->registrarBodega($_POST['bod_numero'], $_POST['bod_nombre']);
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al registrar la bodega: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener todas las bodegas
    public function obtenerTodos() {
        try {
            $resultado = $this->model->obtenerTodasBodegas();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener bodegas: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener una bodega por ID
    public function obtenerPorId($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->obtenerPorIdBodega($id);
            if($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Bodega no encontrada"], 404);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener la bodega: " . $e->getMessage()], 500);
        }
    }
    
    // Actualizar una bodega
    public function actualizarBodega($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $_POST = json_decode(file_get_contents("php://input"), true);
            if(empty($_POST['bod_numero'])) {
                jsonResponse(["status" => false, "msg" => "El número de la bodega es obligatorio"], 400);
                return;
            }
            if(empty($_POST['bod_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la bodega es obligatorio"], 400);
                return;
            }
            if(!testEntero($_POST['bod_numero'])) {
                jsonResponse(["status" => false, "msg" => "El número de la bodega es inválido"], 400);
                return;
            }
            if(testString($_POST['bod_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre de la bodega es inválido"], 400);
                return;
            }
            
            $resultado = $this->model->actualizarBodega($id, $_POST['bod_numero'], $_POST['bod_nombre']);
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar la bodega: " . $e->getMessage()], 500);
        }
    }
    
    // Eliminar una bodega
    public function eliminarBodega($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->eliminarBodega($id);
            if($resultado) {
                jsonResponse(["status" => true, "msg" => "Bodega eliminada correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar la bodega"], 400);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar la bodega: " . $e->getMessage()], 500);
        }
    }
}
?>
