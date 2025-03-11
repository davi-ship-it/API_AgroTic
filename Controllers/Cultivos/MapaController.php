<?php
class MapaController extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Crea un nuevo registro en la tabla mapas.
     * Se espera que la imagen se envíe en $_FILES["map_url_img"].
     */
    public function crear() {
        try {
            /* En caso de usar React:
            $_POST = json_decode(file_get_contents("php://input"), true);
            */

            // Validar que se haya enviado la imagen y que no esté vacía
            if (!isset($_FILES["map_url_img"]) || empty($_FILES["map_url_img"]["name"])) {
                jsonResponse(["status" => false, "msg" => "La imagen no fue enviada"], 400);
                return;
            }
            
            // Procesar la imagen usando la función procesarImg().
            $img_url = procesarImg($_FILES["map_url_img"]);

            $resultado = $this->model->crearMapa($img_url);

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al crear el mapa: " . $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene todos los registros de la tabla mapas.
     */
    public function obtenerTodos() {
        try {
            $resultado = $this->model->obtenerTodosMapas();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener los mapas: " . $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene un registro de mapa por su ID.
     * @param int $id Identificador del mapa.
     */
    public function obtenerPorId($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->obtenerPorIdMapa($id);
            if ($resultado) {
                jsonResponse(["status" => true, "data" => $resultado], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontró el mapa"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el mapa: " . $e->getMessage()], 500);
        }
    }

    /**
     * Actualiza un registro en la tabla mapas.
     * Se procesa una nueva imagen si se envía en $_FILES["map_url_img"].
     * @param int $id Identificador del mapa.
     */
    public function actualizar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            /* En caso de usar React:
            $_POST = json_decode(file_get_contents("php://input"), true);
            */

            // Procesar la imagen solo si se envía una nueva y no está vacía
            $img_url = null;
            if (isset($_FILES["map_url_img"]) && !empty($_FILES["map_url_img"]["name"])) {
                $img_url = procesarImg($_FILES["map_url_img"]);
            }

            $resultado = $this->model->actualizarMapa($id, $img_url);

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar el mapa: " . $e->getMessage()], 500);
        }
    }

    /**
     * Elimina un registro de mapa por su ID.
     * @param int $id Identificador del mapa.
     */
    public function eliminar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->eliminarMapa($id);

            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Mapa eliminado exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el mapa"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar el mapa: " . $e->getMessage()], 500);
        }
    }
}
?>
