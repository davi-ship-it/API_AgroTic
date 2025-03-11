<?php
class CultivosXVariedadController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Crear un nuevo registro en cultivos_x_variedad
    public function crear()
    {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que los campos no estén vacíos
            if (empty($_POST["fk_id_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID del cultivo es obligatorio"], 400);
                return;
            }
            if (empty($_POST["fk_id_variedad"])) {
                jsonResponse(["status" => false, "msg" => "El ID de la variedad es obligatorio"], 400);
                return;
            }

            // Validar que se envíen los IDs numéricos
            if (!is_numeric($_POST["fk_id_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID del cultivo es inválido"], 400);
                return;
            }
            if (!is_numeric($_POST["fk_id_variedad"])) {
                jsonResponse(["status" => false, "msg" => "El ID de la variedad es inválido"], 400);
                return;
            }

            $resultado = $this->model->crearCultivosXVariedad(
                $_POST["fk_id_cultivo"],
                $_POST["fk_id_variedad"]
            );

            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al crear la relación cultivo-variedad: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los registros
    public function obtenerTodos()
    {
        try {
            $resultado = $this->model->obtenerTodosCultivosXVariedad();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener registros: " . $e->getMessage()], 500);
        }
    }

    // Obtener un registro por ID
    public function obtenerPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->obtenerPorIdCultivosXVariedad($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Registro no encontrado"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el registro: " . $e->getMessage()], 500);
        }
    }

    // Actualizar un registro
    public function actualizar($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que los campos no estén vacíos
            if (empty($_POST["fk_id_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID del cultivo es obligatorio"], 400);
                return;
            }
            if (empty($_POST["fk_id_variedad"])) {
                jsonResponse(["status" => false, "msg" => "El ID de la variedad es obligatorio"], 400);
                return;
            }

            // Validar que se envíen los IDs numéricos
            if (!is_numeric($_POST["fk_id_cultivo"])) {
                jsonResponse(["status" => false, "msg" => "El ID del cultivo es inválido"], 400);
                return;
            }
            if (!is_numeric($_POST["fk_id_variedad"])) {
                jsonResponse(["status" => false, "msg" => "El ID de la variedad es inválido"], 400);
                return;
            }

            $resultado = $this->model->actualizarCultivosXVariedad(
                $id,
                $_POST["fk_id_cultivo"],
                $_POST["fk_id_variedad"]
            );

            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar el registro: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un registro
    public function eliminar($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $resultado = $this->model->eliminarCultivosXVariedad($id);
            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Registro eliminado correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el registro"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar el registro: " . $e->getMessage()], 500);
        }
    }
}
?>
