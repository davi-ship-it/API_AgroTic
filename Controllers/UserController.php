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
            // Manejo de método HTTP
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
                return;
            }
    
            // Decodificar el JSON recibido
            $_POST = json_decode(file_get_contents("php://input"), true);

          
    
          
    
            // Validaciones específicas
            if (!testString($_POST["nombres"])) {
                jsonResponse(["status" => false, "msg" => "El nombre es inválido"], 400);
                return;
            }
            if (!testString( $_POST["apellidos"])) {
                jsonResponse(["status" => false, "msg" => "El apellido es inválido"], 400);
                return;
            }
    
            if (!testEntero($_POST["telefono"])) {
                jsonResponse(["status" => false, "msg" => "El teléfono es inválido"], 400);
                return;
            }
    
            if (!verificarCS($_POST["contra"])) {
                jsonResponse(["status" => false, "msg" => "La contraseña es inválida"], 400);
                return;
            }
            if (rol($_POST["rol"])) {
                jsonResponse(["status" => false, "msg" => "el rol es inválido"], 400);
                return;
            }
    
            // Procesamiento de datos
            $data = [
                "nombres"    => ucwords(strtolower($_POST["nombres"])),
                "apellidos"  => ucwords(strtolower($_POST["apellidos"])),
                "DNI"        => $_POST["DNI"],
                "telefono"   => $_POST["telefono"],
                "rol"        => $_POST["rol"],
                "contra"     => encriptarContraseña($_POST["contra"])
            ];
    
            // Llamada al modelo
            $request = $this->model->setUserR(
                $data["nombres"],
                $data["apellidos"],
                $data["contra"],
                $data["telefono"],
                $data["rol"],
                $data["DNI"]
            );
    
            // Respuesta
            if ($request["status"]) {
                jsonResponse([
                    "status" => true,
                    "msg"    => $request["msg"],
                    "data"   => [
                        "idCliente" => $request["id"],
                        "DNI"       => $data["DNI"],
                        "nombres"   => $data["nombres"],
                        "apellidos" => $data["apellidos"],
                        "telefono"  => $data["telefono"],
                        "rol"       => $data["rol"]
                    ]
                ], 200);
            } else {
                jsonResponse(["status" => false, "msg" => $request["msg"]], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error en el servidor: " . $e->getMessage()], 500);
        }
    }

  

public function login()
{
    try {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            jsonResponse(["status" => false, "msg" => "Método no permitido"], 405);
            return;
        }

        $_POST = json_decode(file_get_contents("php://input"), associative: true);

        // Validar campos
        if (empty($_POST["DNI"]) || empty($_POST["contra"])) {
            jsonResponse(["status" => false, "msg" => "DNI y contraseña son requeridos"], 400);
            return;
        }

        $dni = $_POST["DNI"];
        $password = $_POST["contra"];

        // Obtener usuario
        $userRequest = $this->model->getUserByDNI($dni);

        if (!$userRequest["status"]) {
            jsonResponse(["status" => false, "msg" => $userRequest["msg"]], 404);
            return;
        }

        $user = $userRequest["data"];

       // print_r($user);

        // Verificar contraseña
        if (!password_verify($password, $user["password_H"])) {
            jsonResponse(["status" => false, "msg" => "Contraseña incorrecta"], 401);
            return;
        }

        // Generar token JWT
        $secretKey = "tu_clave_secreta_super_segura"; // Cambia esto
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora

        $payload = [
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => [
                "id" => $user["pk_id_usuario"],
                "dni" => $user["DNI"],
                "rol" => $user["rol"]
            ]
        ];

        $token = JWT::encode($payload, $secretKey, 'HS256');

        jsonResponse([
            "status" => true,
            "msg" => "Login exitoso",
            "data" => [
                "token" => $token,
                "usuario" => [
                    "id" => $user["pk_id_usuario"],
                    "nombres" => $user["nombres"],
                    "rol" => $user["rol"]
                ]
            ]
        ], 200);

    } catch (Exception $e) {
        jsonResponse(["status" => false, "msg" => "Error: " . $e->getMessage()], 500);
    }
}
}
