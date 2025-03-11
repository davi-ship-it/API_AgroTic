<?php

class EPAController extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    function hola(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $nom = $_POST["epa_nombre"];
        echo "hola " . $nom;
    }

    public function crear() {
        try {
            /* Descomentar en caso de usar React:
            $_POST = json_decode(file_get_contents("php://input"), true);
            */

            // Validar que se envíen los campos obligatorios
            if (empty($_POST["epa_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["epa_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es obligatoria"], 400);
                return;
            }
            if (empty($_POST["epa_tipo"])) {
                jsonResponse(["status" => false, "msg" => "El tipo de EPA es obligatorio"], 400);
                return;
            }

            // Validar el formato de los datos
            if (!testString($_POST["epa_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testString($_POST["epa_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es inválida"], 400);
                return;
            }
            if (t_EPA($_POST["epa_tipo"])) {
                jsonResponse(["status" => false, "msg" => "El tipo de EPA es inválido"], 400);
                return;
            }

            // Validar que se haya enviado la imagen
            if (!isset($_FILES["epa_img_url"]) || empty($_FILES["epa_img_url"]["name"])) {
                jsonResponse(["status" => false, "msg" => "La imagen no fue enviada"], 400);
                return;
            }

            // Procesar la imagen usando la llave "epa_img_url" de $_FILES.
            $img_url = procesarImg($_FILES["epa_img_url"]);

            $resultado = $this->model->crearEPA(
                $_POST['epa_nombre'],
                $_POST['epa_descripcion'],
                $img_url,
                $_POST['epa_tipo']
            );

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        try {
            $resultado = $this->model->obtenerTodosM();
            jsonResponse(["status" => true, "data" => $resultado], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener datos: " . $e->getMessage()], 500);
        }
    }

    // Obtener un registro por ID
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

    // Actualizar un registro
    public function actualizar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            /* Descomentar en caso de usar React:
            $_POST = json_decode(file_get_contents("php://input"), true);
            */

            // Validar que se envíen los campos obligatorios
            if (empty($_POST["epa_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["epa_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es obligatoria"], 400);
                return;
            }
            if (empty($_POST["epa_tipo"])) {
                jsonResponse(["status" => false, "msg" => "El tipo de EPA es obligatorio"], 400);
                return;
            }

            // Validar el formato de los datos
            if (!testString($_POST["epa_nombre"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testString($_POST["epa_descripcion"])) {
                jsonResponse(["status" => false, "msg" => "La descripción es inválida"], 400);
                return;
            }
            if (t_EPA($_POST["epa_tipo"])) {
                jsonResponse(["status" => false, "msg" => "El tipo de EPA es inválido"], 400);
                return;
            }

            // Procesar la imagen solo si se envía una nueva y no está vacía
            $img_url = isset($_FILES["epa_img_url"]) && !empty($_FILES["epa_img_url"]["name"]) 
                ? procesarImg($_FILES["epa_img_url"]) 
                : null;

            $resultado = $this->model->actualizarEPA_M(
                $id,
                $_POST['epa_nombre'],
                $_POST['epa_descripcion'],
                $img_url,
                $_POST['epa_tipo']
            );

            jsonResponse($resultado, 200);

        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar la EPA: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un registro
    public function eliminar($id) {
        try {
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $resultado = $this->model->eliminarEPA($id);

            if ($resultado) {
                jsonResponse(["status" => true, "msg" => "Registro eliminado exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el registro"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar: " . $e->getMessage()], 500);
        }
    }
}
?>
