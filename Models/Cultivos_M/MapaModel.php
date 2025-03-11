<?php
class MapaModel extends Mysql {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Crea un nuevo registro en la tabla mapas.
     * @param string $img_url Ruta o URL de la imagen procesada.
     * @return array Resultado de la operación.
     */
    public function crearMapa(string $img_url) {
        try {
            $sql = "INSERT INTO mapas (map_url_img) VALUES (:map_url_img)";
            $arrData = [
                "map_url_img" => $img_url
            ];
            // Se asume que el método insert() de la clase Mysql retorna un array con la clave "id".
            $result = $this->insert($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Mapa creado correctamente.",
                "id"     => $result["id"]
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al crear el mapa: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene todos los registros de la tabla mapas.
     * @return array Lista de mapas.
     * @throws Exception Si ocurre un error en la consulta.
     */
    public function obtenerTodosMapas() {
        try {
            $sql = "SELECT * FROM mapas";
            // Se asume que select_all() retorna todos los registros.
            $mapas = $this->select_all($sql);
            return $mapas;
        } catch (Exception $e) {
            throw new Exception("Error al obtener mapas: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un mapa por su ID.
     * @param int $id Identificador del mapa.
     * @return array|null Datos del mapa o null si no se encuentra.
     * @throws Exception Si ocurre un error en la consulta.
     */
    public function obtenerPorIdMapa(int $id) {
        try {
            $sql = "SELECT * FROM mapas WHERE pk_id_mapa = :id";
            $arrData = [":id" => $id];
            // Se asume que select() retorna un único registro.
            $mapa = $this->select($sql, $arrData);
            return $mapa;
        } catch (Exception $e) {
            throw new Exception("Error al obtener el mapa: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un registro de la tabla mapas.
     * Si no se envía una nueva imagen, se mantiene la imagen actual.
     * @param int $id Identificador del mapa.
     * @param string|null $img_url Nueva ruta o URL de la imagen procesada.
     * @return array Resultado de la operación.
     */
    public function actualizarMapa(int $id, ?string $img_url) {
        try {
            if ($img_url !== null) {
                $sql = "UPDATE mapas SET map_url_img = :map_url_img WHERE pk_id_mapa = :id";
                $arrData = [
                    "map_url_img" => $img_url,
                    "id" => $id
                ];
                // Se asume que update() ejecuta la consulta y retorna un resultado.
                $this->update($sql, $arrData);
                return [
                    "status" => true,
                    "msg"    => "Mapa actualizado correctamente.",
                    "id"     => $id
                ];
            } else {
                // Si no se envió nueva imagen, se podría retornar un mensaje indicando que no hubo cambios.
                return [
                    "status" => true,
                    "msg"    => "No se actualizó la imagen, datos sin cambios.",
                    "id"     => $id
                ];
            }
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar el mapa: " . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un registro de la tabla mapas.
     * @param int $id Identificador del mapa.
     * @return bool Resultado de la operación.
     * @throws Exception Si ocurre un error en la eliminación.
     */
    public function eliminarMapa(int $id) {
        try {
            $sql = "DELETE FROM mapas WHERE pk_id_mapa = :id";
            $arrData = [":id" => $id];
            // Se asume que delete() ejecuta la consulta y retorna un resultado booleano.
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el mapa: " . $e->getMessage());
        }
    }
}
?>
