<?php

class VariedadController extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    // Crear un nuevo registro de variedad
    public function crearV() {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que se haya enviado el nombre y el ID de tipo de cultivo
            if (empty($_POST["var_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["fk_id_tipo_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID de tipo de cultivo es obligatorio"], 400);
                return;
            }

            // Validar formato de los datos
            if (!testString($_POST["var_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!is_numeric($_POST["fk_id_tipo_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID de tipo de cultivo es inválido"], 400);
                return;
            }

            $resultado = $this->model->crearVariedad($_POST['var_nombre'], $_POST['fk_id_tipo_cultivo']);
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al crear la variedad: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los registros de variedad
    public function obtenerTodosVariedad() {
        try {
            $resultado = $this->model->obtenerVariedades();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener variedades: " . $e->getMessage()], 500);
        }
    }

    // Filtrar un registro de variedad por ID
    public function filtrarVariedades($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->obtenerPorIdVariedad($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontró la variedad"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener la variedad: " . $e->getMessage()], 500);
        }
    }

    // Actualizar un registro de variedad
    public function actualizar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que se haya enviado el nombre y el ID de tipo de cultivo
            if (empty($_POST["var_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["fk_id_tipo_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID de tipo de cultivo es obligatorio"], 400);
                return;
            }

            // Validar formato de los datos
            if (!testString($_POST["var_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!is_numeric($_POST["fk_id_tipo_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID de tipo de cultivo es inválido"], 400);
                return;
            }

            $resultado = $this->model->actualizarVariedad($id, $_POST['var_nombre'], $_POST['fk_id_tipo_cultivo']);
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar la variedad: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un registro de variedad
    public function eliminar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->eliminarVariedad($id);
            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Variedad eliminada exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar la variedad"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar la variedad: " . $e->getMessage()], 500);
        }
    }
}
?>
