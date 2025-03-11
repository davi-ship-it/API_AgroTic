<?php

class UserModel extends Mysql
{
    private $usu_nombres;
    private $usu_apellidos;
    private $usu_password_H;
    private $usu_telefono;
    private $usu_rol;
    private $usu_dni;

    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase MySQL.
    }

    public function hola()
    {
        echo "Hola mundo";
    }

    public function setUserR($nombres, $apellidos, $password_H, $telefono, $rol, $dni)
    {
        try {
            $this->usu_nombres      = $nombres;
            $this->usu_apellidos    = $apellidos;
            $this->usu_password_H   = $password_H;
            $this->usu_telefono     = $telefono;
            $this->usu_rol          = $rol;
            $this->usu_dni          = $dni;

            // Verificar si el usuario ya existe
            $sql = "SELECT usu_dni FROM usuarios WHERE usu_dni = :usu_dni";
            $params = [":usu_dni" => $this->usu_dni];
            $request = $this->select($sql, $params);

            if (!empty($request)) {
                return ["status" => false, "msg" => "El usuario ya existe"];
            }

            // Insertar nuevo usuario
            $query = "INSERT INTO usuarios (usu_nombres, usu_apellidos, usu_password_H, usu_telefono, usu_rol, usu_dni) 
                      VALUES (:usu_nombres, :usu_apellidos, :usu_password_H, :usu_telefono, :usu_rol, :usu_dni)";
            $data = [
                ":usu_nombres"    => $this->usu_nombres,
                ":usu_apellidos"  => $this->usu_apellidos,
                ":usu_password_H" => $this->usu_password_H,
                ":usu_telefono"   => $this->usu_telefono,
                ":usu_rol"        => $this->usu_rol,
                ":usu_dni"        => $this->usu_dni
            ];

            $request_insert = $this->insert($query, $data);

            if (!$request_insert["status"]) {
                return ["status" => false, "msg" => $request_insert["msg"]];
            }

            return [
                "status" => true,
                "msg"    => "Usuario registrado exitosamente",
                "id"     => $request_insert["id"]
            ];
        } catch (Exception $e) {
            error_log("Error en setUserR: " . $e->getMessage());
            return ["status" => false, "msg" => "Error en el servidor"];
        }
    }

    public function getUserByDNI($dni)
    {
        try {
            $this->usu_dni = $dni;
            $sql = "SELECT * FROM usuarios WHERE usu_dni = :usu_dni";
            $params = [":usu_dni" => $this->usu_dni];
            $request = $this->select($sql, $params);

            if (!empty($request)) {
                return [
                    "status" => true,
                    "msg"    => "El usuario existe",
                    "data"   => $request
                ];
            }

            return [
                "status" => false,
                "msg"    => "El usuario no existe"
            ];
        } catch (Exception $e) {
            error_log("Error en getUserByDNI: " . $e->getMessage());
            return [
                "status" => false,
                "msg"    => "Error al consultar el usuario",
                "error"  => $e->getMessage()
            ];
        }
    }
}
