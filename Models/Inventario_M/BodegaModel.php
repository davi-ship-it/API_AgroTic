<?php
class BodegaModel extends Mysql {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Inserta una nueva bodega
    public function registrarBodega(string $bod_numero, string $bod_nombre) {
        try {
            $sql = "INSERT INTO bodega (bod_numero, bod_nombre) VALUES (:bod_numero, :bod_nombre)";
            $arrData = [
                "bod_numero" => $bod_numero,
                "bod_nombre" => $bod_nombre
            ];
            $result = $this->insert($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Bodega registrada correctamente",
                "id"     => $result["id"]
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al registrar la bodega: " . $e->getMessage()
            ];
        }
    }
    
    // Obtiene todas las bodegas
    public function obtenerTodasBodegas() {
        try {
            $sql = "SELECT * FROM bodega";
            return $this->select_all($sql);
        } catch(Exception $e) {
            throw new Exception("Error al obtener bodegas: " . $e->getMessage());
        }
    }
    
    // Obtiene una bodega por su ID
    public function obtenerPorIdBodega(int $id) {
        try {
            $sql = "SELECT * FROM bodega WHERE pk_id_bodega = :id";
            $arrData = [":id" => $id];
            return $this->select($sql, $arrData);
        } catch(Exception $e) {
            throw new Exception("Error al obtener la bodega: " . $e->getMessage());
        }
    }
    
    // Actualiza una bodega
    public function actualizarBodega(int $id, string $bod_numero, string $bod_nombre) {
        try {
            $sql = "UPDATE bodega SET bod_numero = :bod_numero, bod_nombre = :bod_nombre WHERE pk_id_bodega = :id";
            $arrData = [
                "bod_numero" => $bod_numero,
                "bod_nombre" => $bod_nombre,
                "id"         => $id
            ];
            $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Bodega actualizada correctamente",
                "id"     => $id
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar la bodega: " . $e->getMessage()
            ];
        }
    }
    
    // Elimina una bodega
    public function eliminarBodega(int $id) {
        try {
            $sql = "DELETE FROM bodega WHERE pk_id_bodega = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch(Exception $e) {
            throw new Exception("Error al eliminar la bodega: " . $e->getMessage());
        }
    }
}
?>
