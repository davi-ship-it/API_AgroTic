<?php
class CultivoModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Registra un nuevo cultivo.
     *
     * @param string $descripcion
     * @param string $siembra (fecha en formato válido)
     * @return array Resultado de la operación.
     */
    public function registrarCultivo(string $descripcion, string $siembra)
    {
        try {
            $sql = "INSERT INTO cultivos (cul_descripcion, cul_siembra) 
                    VALUES (:cul_descripcion, :cul_siembra)";
            $arrData = [
                ":cul_descripcion" => $descripcion,
                ":cul_siembra"     => $siembra
            ];

            // Se asume que el método insert() retorna un array con la clave "id"
            $result = $this->insert($sql, $arrData);


            return [
                "status" => true,
                "msg"    => "Cultivo registrado correctamente.",
                "id"     => $result["id"]
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al registrar cultivo: " . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene todos los cultivos.
     *
     * @return array Lista de cultivos.
     * @throws Exception Si ocurre un error en la consulta.
     */
    public function obtenerTodosCultivos()
    {
        try {
            $sql = "SELECT * FROM cultivos";
            $cultivos = $this->select_all($sql);
            return $cultivos;
        } catch (Exception $e) {
            throw new Exception("Error al obtener cultivos: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un cultivo por su ID.
     *
     * @param int $id
     * @return array|null Registro del cultivo o null si no se encuentra.
     * @throws Exception Si ocurre un error en la consulta.
     */
    public function obtenerPorIdCultivo(int $id)
    {
        try {
            $sql = "SELECT * FROM cultivos WHERE pk_id_cultivo = :id";
            $arrData = [":id" => $id];
            $cultivo = $this->select($sql, $arrData);
            return $cultivo;
        } catch (Exception $e) {
            throw new Exception("Error al obtener el cultivo: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un cultivo existente.
     *
     * @param int $id
     * @param string $descripcion
     * @param string $siembra
     * @return array Resultado de la operación.
     */
    public function actualizarCultivo(int $id, string $descripcion, string $siembra)
    {
        try {
            $sql = "UPDATE cultivos 
                    SET cul_descripcion = :cul_descripcion, 
                        cul_siembra = :cul_siembra 
                    WHERE pk_id_cultivo = :id";
            $arrData = [
                ":cul_descripcion" => $descripcion,
                ":cul_siembra"     => $siembra,
                ":id"              => $id
            ];

            // Se asume que el método update() ejecuta la actualización
            $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Cultivo actualizado correctamente.",
                "id"     => $id
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar cultivo: " . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un cultivo de la base de datos.
     *
     * @param int $id
     * @return bool Resultado de la operación.
     * @throws Exception Si ocurre un error en la eliminación.
     */
    public function eliminarCultivo(int $id)
    {
        try {
            $sql = "DELETE FROM cultivos WHERE pk_id_cultivo = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el cultivo: " . $e->getMessage());
        }
    }
}
?>
