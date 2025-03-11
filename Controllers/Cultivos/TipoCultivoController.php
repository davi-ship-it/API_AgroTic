<?php

class TipoCultivoController extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    // Crear un nuevo tipo de cultivo
    public function crearTC() {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que el campo tpc_nombre no esté vacío
            if (empty($_POST["tpc_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            
            // Validar que el nombre tenga un formato correcto
            if (!testString($_POST["tpc_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }

            $resultado = $this->model->crearTipoCultivo($_POST['tpc_nombre']);
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al crear tipo de cultivo: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los tipos de cultivo
    public function obtenerTodosTipos() {
        try {
            $resultado = $this->model->obtenerTodosM();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener datos: " . $e->getMessage()], 500);
        }
    }

    // Obtener un tipo de cultivo por ID
    public function obtenerPorId($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->obtenerPorIdM($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontró el registro"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el registro: " . $e->getMessage()], 500);
        }
    }

    // Actualizar un tipo de cultivo
    public function actualizar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            // Descomentar en caso de usar React:
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que el campo tpc_nombre no esté vacío
            if (empty($_POST["tpc_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            
            // Validar que el nombre tenga un formato correcto
            if (!testString($_POST["tpc_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }

            $resultado = $this->model->actualizarTipoCultivo($id, $_POST['tpc_nombre']);
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar tipo de cultivo: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un tipo de cultivo
    public function eliminar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->eliminarTipoCultivo($id);
            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Tipo de cultivo eliminado exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el tipo de cultivo"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar: " . $e->getMessage()], 500);
        }
    }
}
?>
