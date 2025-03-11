<?php
class CultivosVariedadXLoteModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crea un nuevo registro en cultivos_variedad_x_lote.
     *
     * @param int $fk_id_cultivos_x_variedad
     * @param int $fk_id_lote
     * @return array Resultado de la operación.
     */
    public function crearCultivosVariedadXLote(int $fk_id_cultivos_x_variedad, int $fk_id_lote)
    {
        try {
            $sql = "INSERT INTO cultivos_variedad_x_lote (fk_id_cultivos_x_variedad, fk_id_lote)
                    VALUES (:fk_id_cultivos_x_variedad, :fk_id_lote)";
            $arrData = [
                "fk_id_cultivos_x_variedad" => $fk_id_cultivos_x_variedad,
                "fk_id_lote"                => $fk_id_lote
            ];
            $result = $this->insert($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Registro creado correctamente.",
                "id"     => $result["id"]
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al crear la relación cultivo-variedad-lote: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene todos los registros de cultivos_variedad_x_lote.
     *
     * @return array Lista de registros.
     * @throws Exception Si ocurre un error.
     */
    public function obtenerTodosCultivosVariedadXLote()
    {
        try {
            $sql = "SELECT * FROM cultivos_variedad_x_lote";
            $registros = $this->select_all($sql);
            return $registros;
        } catch (Exception $e) {
            throw new Exception("Error al obtener registros: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un registro por su ID.
     *
     * @param int $id
     * @return array|null Registro encontrado o null.
     * @throws Exception Si ocurre un error.
     */
    public function obtenerPorIdCultivosVariedadXLote(int $id)
    {
        try {
            $sql = "SELECT * FROM cultivos_variedad_x_lote WHERE pk_id_cv_lote = :id";
            $arrData = [":id" => $id];
            $registro = $this->select($sql, $arrData);
            return $registro;
        } catch (Exception $e) {
            throw new Exception("Error al obtener el registro: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un registro en cultivos_variedad_x_lote.
     *
     * @param int $id
     * @param int $fk_id_cultivos_x_variedad
     * @param int $fk_id_lote
     * @return array Resultado de la operación.
     */
    public function actualizarCultivosVariedadXLote(int $id, int $fk_id_cultivos_x_variedad, int $fk_id_lote)
    {
        try {
            $sql = "UPDATE cultivos_variedad_x_lote 
                    SET fk_id_cultivos_x_variedad = :fk_id_cultivos_x_variedad,
                        fk_id_lote = :fk_id_lote 
                    WHERE pk_id_cv_lote = :id";
            $arrData = [
                "fk_id_cultivos_x_variedad" => $fk_id_cultivos_x_variedad,
                "fk_id_lote"                => $fk_id_lote,
                "id"                        => $id
            ];
            $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Registro actualizado correctamente.",
                "id"     => $id
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar la relación cultivo-variedad-lote: " . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un registro de cultivos_variedad_x_lote.
     *
     * @param int $id
     * @return bool Resultado de la operación.
     * @throws Exception Si ocurre un error.
     */
    public function eliminarCultivosVariedadXLote(int $id)
    {
        try {
            $sql = "DELETE FROM cultivos_variedad_x_lote WHERE pk_id_cv_lote = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el registro: " . $e->getMessage());
        }
    }
}
?>

