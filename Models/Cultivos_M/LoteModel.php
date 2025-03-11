<?php
class LoteModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registrarLote(string $nombre, int $coorX, int $coorY, int $fkIdMapa)
    {
        try {
            $sql = "INSERT INTO lotes (lot_nombre, lot_coor_x, lot_coor_y, fk_id_mapa) 
                    VALUES (:lot_nombre, :lot_coor_x, :lot_coor_y, :fk_id_mapa)";
            $arrData = [
                'lot_nombre'  => $nombre,
                'lot_coor_x'  => $coorX,
                'lot_coor_y'  => $coorY,
                'fk_id_mapa'  => $fkIdMapa
            ];

            
            $result = $this->insert($sql, $arrData);

            return [
                "status" => true,
                "msg"    => "Lote registrado correctamente.",
                "id"     => $result["id"]
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al registrar Lote: " . $e->getMessage()
            ];
        }
    }

   
    public function obtenerTodosLotes()
    {
        try {
            $sql = "SELECT * FROM lotes";
            // Se asume que $this->select_all() es un método de la clase Mysql que retorna todos los registros.
            $lotes = $this->select_all($sql);
            return $lotes;
        } catch (Exception $e) {
            throw new Exception("Error al obtener lotes: " . $e->getMessage());
        }
    }

    public function obtenerPorIdLote(int $id)
    {
        try {
            $sql = "SELECT * FROM lotes WHERE pk_id_lote = :id";
            $arrData = [":id" => $id];
            // Se asume que $this->select() es un método de la clase Mysql que retorna un solo registro.
            $lote = $this->select($sql, $arrData);
            return $lote;
        } catch (Exception $e) {
            throw new Exception("Error al obtener el lote: " . $e->getMessage());
        }
    }

    public function actualizarLote(int $id, string $nombre, int $coorX, int $coorY, int $fkIdMapa)
    {
        try {
            $sql = "UPDATE lotes 
                    SET lot_nombre = :lot_nombre, 
                        lot_coor_x = :lot_coor_x, 
                        lot_coor_y = :lot_coor_y, 
                        fk_id_mapa = :fk_id_mapa 
                    WHERE pk_id_lote = :id";
            $arrData = [
                'lot_nombre'  => $nombre,
                'lot_coor_x'  => $coorX,
                'lot_coor_y'  => $coorY,
                'fk_id_mapa'  => $fkIdMapa,
                'id'          => $id
            ];

            // Se asume que $this->update() es un método de la clase Mysql para ejecutar actualizaciones.
            $result = $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Lote actualizado correctamente.",
                "id"     => $id
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar Lote: " . $e->getMessage()
            ];
        }
    }

    
    public function eliminarLote(int $id)
    {
        try {
            $sql = "DELETE FROM lotes WHERE pk_id_lote = :id";
            $arrData = [":id" => $id];
            // Se asume que $this->delete() es un método de la clase Mysql que ejecuta la eliminación.
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el lote: " . $e->getMessage());
        }
    }

    public function buscarPorNombre(string $nombre)
    {
        try {
            // Se arma la consulta usando LIKE para hacer búsquedas parciales.
            $sql = "SELECT * FROM lotes WHERE lot_nombre LIKE :nombre";
            $arrData = [":nombre" => "%" . $nombre . "%"];
            // Se asume que select_all() es un método heredado de Mysql que retorna todos los registros.
            $registros = $this->select_all($sql, $arrData);
            return $registros;
        } catch (Exception $e) {
            throw new Exception("Error en la búsqueda: " . $e->getMessage());
        }
    }
}
?>
