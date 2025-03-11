<?php
class InventarioController extends Controllers {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Registrar un nuevo inventario
    public function registrarInventario() {
        try {

            //descomentar en react
            
         /*   $_POST = json_decode(file_get_contents("php://input"), true);
           */ 
            // Validación de campos obligatorios usando empty()
            if(empty($_POST['inv_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre del inventario es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_stock'])) {
                jsonResponse(["status" => false, "msg" => "El stock es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_precio'])) {
                jsonResponse(["status" => false, "msg" => "El precio es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_tipo_unidad'])) {
                jsonResponse(["status" => false, "msg" => "El tipo de unidad es obligatorio"], 400);
                return;
            }
            if(!isset($_POST['inv_disponibilidad'])) { // Puede venir como 0/1 o booleano
                jsonResponse(["status" => false, "msg" => "La disponibilidad es obligatoria"], 400);
                return;
            }
            if(empty($_POST['fk_id_categoria'])) {
                jsonResponse(["status" => false, "msg" => "La categoría es obligatoria"], 400);
                return;
            }
            if(empty($_POST['fk_id_bodega'])) {
                jsonResponse(["status" => false, "msg" => "La bodega es obligatoria"], 400);
                return;
            }
            // Validar la imagen (debe enviarse en $_FILES)
            if(!isset($_FILES["inv_img_url"])) {
                jsonResponse(["status" => false, "msg" => "La imagen es obligatoria"], 400);
                return;
            }
            // Procesar la imagen
            $img_url = procesarImg($_FILES["inv_img_url"]);
            
            // inv_descripcion es opcional
            $descripcion = isset($_POST['inv_descripcion']) ? $_POST['inv_descripcion'] : "";
            
            $resultado = $this->model->registrarInventario(
                $_POST['inv_nombre'],
                $descripcion,
                (int)$_POST['inv_stock'],
                (int)$_POST['inv_precio'],
                $_POST['inv_tipo_unidad'],
                (bool)$_POST['inv_disponibilidad'],
                $img_url,
                (int)$_POST['fk_id_categoria'],
                (int)$_POST['fk_id_bodega']
            );
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al registrar el inventario: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener todos los inventarios
    public function obtenerTodos() {
        try {
            $resultado = $this->model->obtenerTodosInventarios();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener inventarios: " . $e->getMessage()], 500);
        }
    }
    
    // Obtener un inventario por ID
    public function obtenerPorId($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->obtenerPorIdInventario($id);
            if($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Inventario no encontrado"], 404);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el inventario: " . $e->getMessage()], 500);
        }
    }
    
    // Actualizar un inventario existente
    public function actualizarInventario($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $_POST = json_decode(file_get_contents("php://input"), true);
            // Validación de campos obligatorios
            if(empty($_POST['inv_nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre del inventario es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_stock'])) {
                jsonResponse(["status" => false, "msg" => "El stock es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_precio'])) {
                jsonResponse(["status" => false, "msg" => "El precio es obligatorio"], 400);
                return;
            }
            if(empty($_POST['inv_tipo_unidad'])) {
                jsonResponse(["status" => false, "msg" => "El tipo de unidad es obligatorio"], 400);
                return;
            }
            if(!isset($_POST['inv_disponibilidad'])) {
                jsonResponse(["status" => false, "msg" => "La disponibilidad es obligatoria"], 400);
                return;
            }
            if(empty($_POST['fk_id_categoria'])) {
                jsonResponse(["status" => false, "msg" => "La categoría es obligatoria"], 400);
                return;
            }
            if(empty($_POST['fk_id_bodega'])) {
                jsonResponse(["status" => false, "msg" => "La bodega es obligatoria"], 400);
                return;
            }
            // Procesar imagen si se envía una nueva
            $img_url = isset($_FILES["inv_img_url"]) ? procesarImg($_FILES["inv_img_url"]) : null;
            
            $descripcion = isset($_POST['inv_descripcion']) ? $_POST['inv_descripcion'] : "";
            
            $resultado = $this->model->actualizarInventario(
                $id,
                $_POST['inv_nombre'],
                $descripcion,
                (int)$_POST['inv_stock'],
                (int)$_POST['inv_precio'],
                $_POST['inv_tipo_unidad'],
                (bool)$_POST['inv_disponibilidad'],
                $img_url,
                (int)$_POST['fk_id_categoria'],
                (int)$_POST['fk_id_bodega']
            );
            jsonResponse($resultado, 200);
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar el inventario: " . $e->getMessage()], 500);
        }
    }
    
    // Eliminar un inventario
    public function eliminarInventario($id) {
        try {
            if(!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->eliminarInventario($id);
            if($resultado) {
                jsonResponse(["status" => true, "msg" => "Inventario eliminado correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el inventario"], 400);
            }
        } catch(Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar el inventario: " . $e->getMessage()], 500);
        }
    }
}
?>
