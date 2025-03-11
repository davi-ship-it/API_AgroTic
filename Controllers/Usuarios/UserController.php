<?php

use Firebase\JWT\JWT;

class UserController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    } 

    public function registro()
    {
        try {
            // Verificar método HTTP
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }

            // Decodificar el JSON recibido
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validaciones: Verificar que se envíen los campos obligatorios
            if (empty($_POST["usu_nombres"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_apellidos"])) {
                jsonResponse(["status" => false, "msg" => "El apellido es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_telefono"])) {
                jsonResponse(["status" => false, "msg" => "El teléfono es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_dni"])) {
                jsonResponse(["status" => false, "msg" => "El DNI es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_password_H"])) {
                jsonResponse(["status" => false, "msg" => "La contraseña es obligatoria"], 400);
                return;
            }
            if (empty($_POST["usu_rol"])) {
                jsonResponse(["status" => false, "msg" => "El rol es obligatorio"], 400);
                return;
            }

            // Validaciones de formato
            if (!testString($_POST["usu_nombres"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testString($_POST["usu_apellidos"])) {
                jsonResponse(["status" => false, "msg" => "El apellido es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["usu_telefono"])) {
                jsonResponse(["status" => false, "msg" => "El teléfono es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["usu_dni"])) {
                jsonResponse(["status" => false, "msg" => "El DNI es inválido"], 400);
                return;
            }
            if (!verificarCS($_POST["usu_password_H"])) {
                jsonResponse(["status" => false, "msg" => "La contraseña es inválida"], 400);
                return;
            }
            if (rol($_POST["usu_rol"])) {
                jsonResponse(["status" => false, "msg" => "El rol es inválido"], 400);
                return;
            }
    
            // Procesamiento de datos
            $data = [
                "usu_nombres"      => ucwords(strtolower($_POST["usu_nombres"])),
                "usu_apellidos"    => ucwords(strtolower($_POST["usu_apellidos"])),
                "usu_dni"          => $_POST["usu_dni"],
                "usu_telefono"     => $_POST["usu_telefono"],
                "usu_rol"          => $_POST["usu_rol"],
                "usu_password_H"   => encriptarContraseña($_POST["usu_password_H"])
            ];
    
            // Llamada al modelo para insertar el usuario
            $request = $this->model->setUserR(
                $data["usu_nombres"],
                $data["usu_apellidos"],
                $data["usu_password_H"],
                $data["usu_telefono"], 
                $data["usu_rol"],
                $data["usu_dni"]
            );
     
            // Respuesta
            if ($request["status"]) {
                jsonResponse([
                    "status" => true,
                    "msg"    => $request["msg"],
                    "data"   => [
                        "pk_id_usuario" => $request["id"],
                        "usu_dni"       => $data["usu_dni"],
                        "usu_nombres"   => $data["usu_nombres"],
                        "usu_apellidos" => $data["usu_apellidos"],
                        "usu_telefono"  => $data["usu_telefono"],
                        "usu_rol"       => $data["usu_rol"]
                    ]
                ], 200);
            } else {
                jsonResponse(["status" => false, "msg" => $request["msg"]], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error en el servidor: " . $e->getMessage()], 500);
        }
    }

    // LOGIN: Autenticar usuario y generar token JWT
    public function login()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar que se envíen DNI y contraseña
            if (empty($_POST["usu_dni"]) || empty($_POST["usu_password_H"])) {
                jsonResponse(["status" => false, "msg" => "DNI y contraseña son requeridos"], 400);
                return;
            }

            $dni = $_POST["usu_dni"];
            $password = $_POST["usu_password_H"];

            // Obtener usuario por DNI
            $userRequest = $this->model->getUserByDNI($dni);
            if (!$userRequest["status"]) {
                jsonResponse(["status" => false, "msg" => $userRequest["msg"]], 404);
                return;
            }

            $user = $userRequest["data"];

            // Verificar contraseña
            if (!password_verify($password, $user["usu_password_H"])) {
                jsonResponse(["status" => false, "msg" => "Contraseña incorrecta"], 401);
                return;
            }

            // Generar token JWT
            $secretKey = "tu_clave_secreta_super_segura"; // Cambia esto por tu clave real
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600; // Token válido por 1 hora

            $payload = [
                "iat"  => $issuedAt,
                "exp"  => $expirationTime,
                "data" => [
                    "id"      => $user["pk_id_usuario"],
                    "usu_dni" => $user["usu_dni"],
                    "usu_rol" => $user["usu_rol"]
                ]
            ];

            $token = JWT::encode($payload, $secretKey, 'HS256');

            jsonResponse([
                "status" => true,
                "msg"    => "Login exitoso",
                "data"   => [
                    "token"   => $token,
                    "usuario" => [
                        "id"          => $user["pk_id_usuario"],
                        "usu_nombres" => $user["usu_nombres"],
                        "usu_rol"     => $user["usu_rol"]
                    ]
                ]
            ], 200);

        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error: " . $e->getMessage()], 500);
        }
    }

    // OBTENER TODOS: Listar todos los usuarios
    public function obtenerTodos()
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }

            $users = $this->model->getAllUsers();
            jsonResponse(["status" => true, "data" => $users], 200);
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener usuarios: " . $e->getMessage()], 500);
        }
    }

    // OBTENER POR ID: Obtener un usuario por su ID
    public function obtenerPorId($id)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }
            $user = $this->model->getUserById($id);
            if ($user) {
                jsonResponse(["status" => true, "data" => $user], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Usuario no encontrado"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al obtener el usuario: " . $e->getMessage()], 500);
        }
    }

    // ACTUALIZAR: Actualizar datos de un usuario
    public function actualizar($id)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validar campos obligatorios para la actualización
            if (empty($_POST["usu_nombres"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_apellidos"])) {
                jsonResponse(["status" => false, "msg" => "El apellido es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_telefono"])) {
                jsonResponse(["status" => false, "msg" => "El teléfono es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_dni"])) {
                jsonResponse(["status" => false, "msg" => "El DNI es obligatorio"], 400);
                return;
            }
            if (empty($_POST["usu_rol"])) {
                jsonResponse(["status" => false, "msg" => "El rol es obligatorio"], 400);
                return;
            }

            // Validar formato de los datos
            if (!testString($_POST["usu_nombres"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testString($_POST["usu_apellidos"])) {
                jsonResponse(["status" => false, "msg" => "El apellido es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["usu_telefono"])) {
                jsonResponse(["status" => false, "msg" => "El teléfono es inválido"], 400);
                return;
            }
            if (!testEntero($_POST["usu_dni"])) {
                jsonResponse(["status" => false, "msg" => "El DNI es inválido"], 400);
                return;
            }
            if (rol($_POST["usu_rol"])) {
                jsonResponse(["status" => false, "msg" => "El rol es inválido"], 400);
                return;
            }

            // Procesar datos actualizados
            $data = [
                "usu_nombres"    => ucwords(strtolower($_POST["usu_nombres"])),
                "usu_apellidos"  => ucwords(strtolower($_POST["usu_apellidos"])),
                "usu_telefono"   => $_POST["usu_telefono"],
                "usu_dni"        => $_POST["usu_dni"],
                "usu_rol"        => $_POST["usu_rol"]
            ];

            $request = $this->model->updateUser(
                $id,
                $data["usu_nombres"],
                $data["usu_apellidos"],
                $data["usu_telefono"],
                $data["usu_dni"],
                $data["usu_rol"]
            );

            if ($request["status"]) {
                jsonResponse([
                    "status" => true,
                    "msg"    => $request["msg"],
                    "data"   => [
                        "pk_id_usuario" => $id,
                        "usu_nombres"   => $data["usu_nombres"],
                        "usu_apellidos" => $data["usu_apellidos"],
                        "usu_telefono"  => $data["usu_telefono"],
                        "usu_dni"       => $data["usu_dni"],
                        "usu_rol"       => $data["usu_rol"]
                    ]
                ], 200);
            } else {
                jsonResponse(["status" => false, "msg" => $request["msg"]], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al actualizar el usuario: " . $e->getMessage()], 500);
        }
    }

    // ELIMINAR: Borrar un usuario por ID
    public function eliminar($id)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }
            if (!is_numeric($id)) {
                jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
                return;
            }

            $request = $this->model->deleteUser($id);
            if ($request["status"]) {
                jsonResponse(["status" => true, "msg" => "Usuario eliminado exitosamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se pudo eliminar el usuario"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error al eliminar el usuario: " . $e->getMessage()], 500);
        }
    }
}
?>
