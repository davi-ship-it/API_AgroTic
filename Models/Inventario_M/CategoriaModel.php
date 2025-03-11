<?php
class CategoriaModel extends Mysql {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Inserta una nueva categoría
    public function registrarCategoria(string $cat_nombre) {
        try {
            $sql = "INSERT INTO categoria (cat_nombre) VALUES (:cat_nombre)";
            $arrData = ["cat_nombre" => $cat_nombre];
            $result = $this->insert($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Categoría registrada correctamente",
                "id"     => $result["id"]
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al registrar la categoría: " . $e->getMessage()
            ];
        }
    }
    
    // Obtiene todas las categorías
    public function obtenerTodasCategorias() {
        try {
            $sql = "SELECT * FROM categoria";
            return $this->select_all($sql);
        } catch(Exception $e) {
            throw new Exception("Error al obtener categorías: " . $e->getMessage());
        }
    }
    
    // Obtiene una categoría por su ID
    public function obtenerPorIdCategoria(int $id) {
        try {
            $sql = "SELECT * FROM categoria WHERE pk_id_categoria = :id";
            $arrData = [":id" => $id];
            return $this->select($sql, $arrData);
        } catch(Exception $e) {
            throw new Exception("Error al obtener la categoría: " . $e->getMessage());
        }
    }
    
    // Actualiza una categoría
    public function actualizarCategoria(int $id, string $cat_nombre) {
        try {
            $sql = "UPDATE categoria SET cat_nombre = :cat_nombre WHERE pk_id_categoria = :id";
            $arrData = [
                "cat_nombre" => $cat_nombre,
                "id"         => $id
            ];
            $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Categoría actualizada correctamente",
                "id"     => $id
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar la categoría: " . $e->getMessage()
            ];
        }
    }
    
    // Elimina una categoría
    public function eliminarCategoria(int $id) {
        try {
            $sql = "DELETE FROM categoria WHERE pk_id_categoria = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch(Exception $e) {
            throw new Exception("Error al eliminar la categoría: " . $e->getMessage());
        }
    }
}
?>
