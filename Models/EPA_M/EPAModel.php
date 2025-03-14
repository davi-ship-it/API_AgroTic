<?php

class EPAModel extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    // Crear nuevo registro
    public function crearEPA($nombre, $descripcion, $imagen, $tipo) {
        try {
            // Procesa la imagen y obtiene la URL o ruta donde fue guardada

            $query = "INSERT INTO epa (epa_nombre, epa_descripcion, epa_img_url, epa_tipo) 
                      VALUES (:epa_nombre, :epa_descripcion, :epa_img_url, :epa_tipo)";

            $params = [
                ':epa_nombre'       => $nombre,
                ':epa_descripcion'  => $descripcion,
                ':epa_img_url'      => $imagen,
                ':epa_tipo'         => $tipo,
            ];

            return $this->insert($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Obtener todos los registros
    public function obtenerTodosM() {
        try {
            $query = "SELECT * FROM epa";
            return $this->select_all($query);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Obtener un registro por ID
    public function obtenerPorIdM($id) {
        try {
            $query = "SELECT * FROM epa WHERE pk_id_epa = :id";
            $params = [':id' => $id];
            return $this->select($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Actualizar un registro
    public function actualizarEPA_M($id, $nombre, $descripcion, $imagen, $tipo) {
        try {
            $query = "UPDATE epa SET 
                        epa_nombre = :epa_nombre, 
                        epa_descripcion = :epa_descripcion, 
                        epa_img_url = :epa_img_url, 
                        epa_tipo = :epa_tipo 
                      WHERE pk_id_epa = :id";

            $params = [
                ':id'               => $id,
                ':epa_nombre'       => $nombre,
                ':epa_descripcion'  => $descripcion,
                ':epa_img_url'      => $imagen,
                ':epa_tipo'         => $tipo,
            ];

            $resultado = $this->update($query, $params);

            if ($resultado) {
                return ["status" => true, "msg" => "EPA actualizada correctamente"];
            } else {
                return ["status" => false, "msg" => "No se pudo actualizar la EPA"];
            }
        } catch (Exception $e) {
            return ["status" => false, "msg" => "Error: " . $e->getMessage()];
        }
    }

    // Eliminar un registro
    public function eliminarEPA($id) {
        try {
            $query = "DELETE FROM epa WHERE pk_id_epa = :id";
            $params = [':id' => $id];
            return $this->delete($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }
}

?>
