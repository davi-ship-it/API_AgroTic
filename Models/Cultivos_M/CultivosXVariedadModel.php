<?php
class CultivosXVariedadModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crea un nuevo registro en la tabla cultivos_x_variedad.
     *
     * @param int $fk_id_cultivo
     * @param int $fk_id_variedad
     * @return array Resultado de la operación.
     */
    public function crearCultivosXVariedad(int $fk_id_cultivo, int $fk_id_variedad)
    {
        try {
            $sql = "INSERT INTO cultivos_x_variedad (fk_id_cultivo, fk_id_variedad)
                    VALUES (:fk_id_cultivo, :fk_id_variedad)";
            $arrData = [
                "fk_id_cultivo" => $fk_id_cultivo,
                "fk_id_variedad" => $fk_id_variedad
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
                "msg"    => "Error al crear la relación cultivo-variedad: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene todos los registros de cultivos_x_variedad.
     *
     * @return array Lista de registros.
     * @throws Exception Si ocurre un error.
     */
    public function obtenerTodosCultivosXVariedad()
    {
        try {
            $sql = "SELECT * FROM cultivos_x_variedad";
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
    public function obtenerPorIdCultivosXVariedad(int $id)
    {
        try {
            $sql = "SELECT * FROM cultivos_x_variedad WHERE pk_id_cultivos_x_variedad = :id";
            $arrData = [":id" => $id];
            $registro = $this->select($sql, $arrData);
            return $registro;
        } catch (Exception $e) {
            throw new Exception("Error al obtener el registro: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un registro en cultivos_x_variedad.
     *
     * @param int $id
     * @param int $fk_id_cultivo
     * @param int $fk_id_variedad
     * @return array Resultado de la operación.
     */
    public function actualizarCultivosXVariedad(int $id, int $fk_id_cultivo, int $fk_id_variedad)
    {
        try {
            $sql = "UPDATE cultivos_x_variedad 
                    SET fk_id_cultivo = :fk_id_cultivo, 
                        fk_id_variedad = :fk_id_variedad 
                    WHERE pk_id_cultivos_x_variedad = :id";
            $arrData = [
                "fk_id_cultivo"  => $fk_id_cultivo,
                "fk_id_variedad" => $fk_id_variedad,
                "id"             => $id
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
                "msg"    => "Error al actualizar la relación cultivo-variedad: " . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un registro de cultivos_x_variedad.
     *
     * @param int $id
     * @return bool Resultado de la operación.
     * @throws Exception Si ocurre un error.
     */
    public function eliminarCultivosXVariedad(int $id)
    {
        try {
            $sql = "DELETE FROM cultivos_x_variedad WHERE pk_id_cultivos_x_variedad = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el registro: " . $e->getMessage());
        }
    }
}
?>
