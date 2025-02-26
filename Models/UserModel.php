<?php

    class UserModel extends Mysql
    {
        private $strNombres;
        private $strApellidos;
        private $strContrasenia_H;
        private $intTelefono;
        private $intDNI;
        private $strRol;
    
        public function __construct()
        {
            parent::__construct(); // Llama al constructor de la clase MySQL.
        }

        public function hola(){
            echo "Hola mundo";
        }


        public function setUserR($nombres, $apellidos, $contrasenia_H, $telefono, $rol, $dni)
        {
            try {
                $this->strNombres = $nombres;
                $this->strApellidos = $apellidos;
                $this->strContrasenia_H = $contrasenia_H;
                $this->intTelefono = $telefono;
                $this->strRol = $rol;
                $this->intDNI = $dni;
        
                // Verificar si el usuario ya existe
                $sql = "SELECT DNI FROM usuarios WHERE DNI = :DNI";
                $params = [":DNI" => $this->intDNI];
                $request = $this->select($sql, $params);
        
                if (!empty($request)) {
                    return ["status" => false, "msg" => "El usuario ya existe"];
                }
        
                // Insertar nuevo usuario
                $query = "INSERT INTO usuarios (nombres, apellidos, password_H, telefono, rol, DNI) 
                          VALUES (:nombres, :apellidos, :password_H, :telefono, :rol, :DNI)";
                $data = [
                    ":nombres"    => $this->strNombres,
                    ":apellidos"  => $this->strApellidos,
                    ":password_H" => $this->strContrasenia_H,
                    ":telefono"   => $this->intTelefono,
                    ":rol"        => $this->strRol,
                    ":DNI"        => $this->intDNI
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

        public function getUserByDNI($intDNI)
        {
            try {
                $this->intDNI = $intDNI;
                $sql = "SELECT * FROM usuarios WHERE DNI = :DNI";
                $params = [":DNI" => $this->intDNI];
                $request = $this->select($sql, $params);
        
                if (!empty($request)) {
                    return [
                        "status" => true,
                        "msg" => "El usuario existe",
                        "data" => $request
                    ];
                }
        
                return [
                    "status" => false,
                    "msg" => "El usuario no existe"
                ];
        
            } catch (Exception $e) {
                error_log("Error en getUserByDNI: " . $e->getMessage());
                return [
                    "status" => false,
                    "msg" => "Error al consultar el usuario",
                    "error" => $e->getMessage()
                ];
            }
        }
        
        
    
    
    }