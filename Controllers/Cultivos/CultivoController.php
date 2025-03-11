<?php 
class CultivoController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Registrar un nuevo cultivo
    public function registrarCultivo()
    {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validación para campos vacíos
            if(empty($_POST["cul_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es obligatoria"], 400);
                return;
            }
            if(empty($_POST["cul_siembra"])) {
                jsonResponse(["status" => false, "msg" => "La fecha de siembra es obligatoria"], 400);
                return;
            }

            // Validación de formato
            if (!testString($_POST["cul_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es inválida"], 400);
                return;
            }
            if (!validateDate($_POST["cul_siembra"])) {
                jsonResponse(["status" => false, "msg" => "La fecha de siembra es inválida"], 400);
                return;
            }

            $resultado = $this->model->registrarCultivo(
                $_POST["cul_descripcion"],
                $_POST["cul_siembra"]
            );
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al registrar el cultivo: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los cultivos
    public function obtenerTodos()
    {
        try {
            $resultado = $this->model->obtenerTodosCultivos();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener cultivos: " . $e->getMessage()], 500);
        }
    }

    // Obtener un cultivo por ID
    public function obtenerPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->obtenerPorIdCultivo($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Cultivo no encontrado"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el cultivo: " . $e->getMessage()], 500);
        }
    }

    // Actualizar un cultivo existente
    public function actualizarCultivo($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validación para campos vacíos
            if(empty($_POST["cul_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es obligatoria"], 400);
                return;
            }
            if(empty($_POST["cul_siembra"])) {
                jsonResponse(["status" => false, "msg" => "La fecha de siembra es obligatoria"], 400);
                return;
            }

            // Validación de formato
            if (!testString($_POST["cul_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es inválida"], 400);
                return;
            }
            if (!validateDate($_POST["cul_siembra"])) {
                jsonResponse(["status" => false, "msg" => "La fecha de siembra es inválida"], 400);
                return;
            }

            $resultado = $this->model->actualizarCultivo(
                $id,
                $_POST["cul_descripcion"],
                $_POST["cul_siembra"]
            );
            jsonResponse($resultado, 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar el cultivo: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un cultivo
    public function eliminarCultivo($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->eliminarCultivo($id);

            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Cultivo eliminado correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el cultivo"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar el cultivo: " . $e->getMessage()], 500);
        }
    }
}
?>
