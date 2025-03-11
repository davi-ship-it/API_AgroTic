<?php

class TipoCultivoModel extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    // Crear nuevo registro
    public function crearTipoCultivo($nombre) {
        try {
            $query = "INSERT INTO tipo_cultivo (tpc_nombre) VALUES (:tpc_nombre)";
            $params = [
                ':tpc_nombre' => $nombre,
            ];
            return $this->insert($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Obtener todos los registros
    public function obtenerTodosM() {
        try {
            $query = "SELECT * FROM tipo_cultivo";
            return $this->select_all($query);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Obtener un registro por ID
    public function obtenerPorIdM($id) {
        try {
            $query = "SELECT * FROM tipo_cultivo WHERE pk_id_tipo_cultivo = :id";
            $params = [':id' => $id];
            return $this->select($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }

    // Actualizar un registro
    public function actualizarTipoCultivo($id, $nombre) {
        try {
            $query = "UPDATE tipo_cultivo SET tpc_nombre = :tpc_nombre WHERE pk_id_tipo_cultivo = :id";
            $params = [
                ':id'         => $id,
                ':tpc_nombre' => $nombre,
            ];
            $resultado = $this->update($query, $params);
            if ($resultado) {
                return ["status" => true, "msg" => "Tipo de cultivo actualizado correctamente"];
            } else {
                return ["status" => false, "msg" => "No se pudo actualizar el tipo de cultivo"];
            }
        } catch (Exception $e) {
            return ["status" => false, "msg" => "Error: " . $e->getMessage()];
        }
    }

    // Eliminar un registro
    public function eliminarTipoCultivo($id) {
        try {
            $query = "DELETE FROM tipo_cultivo WHERE pk_id_tipo_cultivo = :id";
            $params = [':id' => $id];
            return $this->delete($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }
}
?>
