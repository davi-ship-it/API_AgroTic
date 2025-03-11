<?php
class LoteController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Crear un nuevo lote
    public function crearLote()
    {
        try {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validación de campos vacíos
            if(empty($_POST["lot_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if(empty($_POST["lot_coor_x"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada X es obligatoria"], 400);
                return;
            }
            if(empty($_POST["lot_coor_y"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada Y es obligatoria"], 400);
                return;
            }
            if(empty($_POST["fk_id_mapa"])) {
                jsonResponse(["status" => false, "msg" => "El ID del mapa es obligatorio"], 400);
                return;
            }

            // Validación de formato de datos
            if (!testString($_POST["lot_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["lot_coor_x"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada X es inválida"], 400);
                return;
            }
            if (!testEntero($_POST["lot_coor_y"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada Y es inválida"], 400);
                return;
            }
            if (!testEntero($_POST["fk_id_mapa"])) {
                jsonResponse(["status" => false, "msg" => "El ID del mapa es inválido"], 400);
                return;
            }

            // Registro del lote en el modelo
            $resultado = $this->model->registrarLote(
                $_POST["lot_nombre"],
                $_POST["lot_coor_x"],
                $_POST["lot_coor_y"],
                $_POST["fk_id_mapa"]
            );

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al crear el lote: " . $e->getMessage()
            ], 500);
        }
    }

    // Obtener todos los lotes
    public function obtenerTodos()
    {
        try {
            $resultado = $this->model->obtenerTodosLotes();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al obtener los lotes: " . $e->getMessage()
            ], 500);
        }
    }

    // Obtener un lote por ID
    public function obtenerPorId($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->obtenerPorIdLote($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontró el lote"], 404);
            }
        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al obtener el lote: " . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar un lote
    public function actualizar($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            // Se obtiene la información enviada en formato JSON
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validación de campos vacíos
            if(empty($_POST["lot_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if(empty($_POST["lot_coor_x"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada X es obligatoria"], 400);
                return;
            }
            if(empty($_POST["lot_coor_y"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada Y es obligatoria"], 400);
                return;
            }
            if(empty($_POST["fk_id_mapa"])) {
                jsonResponse(["status" => false, "msg" => "El ID del mapa es obligatorio"], 400);
                return;
            }

            // Validación de formato de datos
            if (testString($_POST["lot_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["lot_coor_x"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada X es inválida"], 400);
                return;
            }
            if (!testEntero($_POST["lot_coor_y"])) {
                jsonResponse(["status" => false, "msg" => "La coordenada Y es inválida"], 400);
                return;
            }
            if (!testEntero($_POST["fk_id_mapa"])) {
                jsonResponse(["status" => false, "msg" => "El ID del mapa es inválido"], 400);
                return;
            }

            // Actualización del lote en el modelo
            $resultado = $this->model->actualizarLote(
                $id,
                $_POST["lot_nombre"],
                $_POST["lot_coor_x"],
                $_POST["lot_coor_y"],
                $_POST["fk_id_mapa"]
            );

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al actualizar el lote: " . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar un lote
    public function eliminar($id)
    {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->eliminarLote($id);
            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Lote eliminado exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el lote"], 400);
            }
        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al eliminar el lote: " . $e->getMessage()
            ], 500);
        }
    }

    public function buscarPorNombre()
    {
        try {
            // Obtener los datos enviados en formato JSON.
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que se envíe el nombre y que no esté vacío
            if (empty($_POST["lot_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio y debe ser válido."], 400);
                return;
            }

            $nombre = $_POST["lot_nombre"];

            // Llamar al método del modelo que realiza la búsqueda.
            $resultado = $this->model->buscarPorNombre($nombre);

            // Se retorna la respuesta con los registros encontrados.
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse([
                "status" => false,
                "msg" => "Error al buscar por nombre: " . $e->getMessage()
            ], 500);
        }
    }
}
?>
