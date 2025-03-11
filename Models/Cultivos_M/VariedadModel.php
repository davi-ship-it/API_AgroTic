<?php

class VariedadModel extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    // Crear nuevo registro de variedad
    public function crearVariedad($nombre, $fk_id_tipo_cultivo) {
        try {
            $query = "INSERT INTO variedad (var_nombre, fk_id_tipo_cultivo) 
                      VALUES (:var_nombre, :fk_id_tipo_cultivo)";
            $params = [
                ':var_nombre' => $nombre,
                ':fk_id_tipo_cultivo' => $fk_id_tipo_cultivo,
            ];
            return $this->insert($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }
    
    // Obtener un registro por ID
    public function obtenerPorIdVariedad($id) {
        try {
            $query = "SELECT * FROM variedad WHERE fk_id_tipo_cultivo = :id";
            $params = [':id' => $id];
            return $this->select($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }


    
    // Obtener todos los registros de variedad
  
  public function obtenerVariedades($idTipoCultivo = null) {
        try {
            if (!is_null($idTipoCultivo)) {
                // Si se pasa el id, se obtienen todas las variedades de ese tipo
                $query = "SELECT 
                            v.pk_id_variedad, 
                            v.var_nombre, 
                            t.tpc_nombre AS tipo_cultivo
                          FROM 
                            variedad v
                          INNER JOIN 
                            tipo_cultivo t 
                          ON v.fk_id_tipo_cultivo = t.pk_id_tipo_cultivo
                          WHERE v.fk_id_tipo_cultivo = $idTipoCultivo";
                $params = [$idTipoCultivo];
            } else {
                // Si no se pasa parámetro, se listan los tipos de cultivo de forma única
                $query = "SELECT DISTINCT
                            t.pk_id_tipo_cultivo,
                            t.tpc_nombre AS tipo_cultivo
                          FROM 
                            tipo_cultivo t
                          INNER JOIN 
                            variedad v 
                          ON v.fk_id_tipo_cultivo = t.pk_id_tipo_cultivo";
                $params = [];
            }
            
            return $this->select_all($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }


    // Actualizar un registro de variedad
    public function actualizarVariedad($id, $nombre, $fk_id_tipo_cultivo) {
        try {
            $query = "UPDATE variedad SET 
                        var_nombre = :var_nombre, 
                        fk_id_tipo_cultivo = :fk_id_tipo_cultivo 
                      WHERE pk_id_variedad = :id";
            $params = [
                ':id'               => $id,
                ':var_nombre'       => $nombre,
                ':fk_id_tipo_cultivo' => $fk_id_tipo_cultivo,
            ];
            $resultado = $this->update($query, $params);
            if ($resultado) {
                return ["status" => true, "msg" => "Variedad actualizada correctamente"];
            } else {
                return ["status" => false, "msg" => "No se pudo actualizar la variedad"];
            }
        } catch (Exception $e) {
            return ["status" => false, "msg" => "Error: " . $e->getMessage()];
        }
    }

    // Eliminar un registro de variedad
    public function eliminarVariedad($id) {
        try {
            $query = "DELETE FROM variedad WHERE pk_id_variedad = :id";
            $params = [':id' => $id];
            return $this->delete($query, $params);
        } catch (Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage()];
        }
    }
}
?>
