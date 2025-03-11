<?php
class InventarioModel extends Mysql {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Inserta un nuevo registro en inventario
    public function registrarInventario(
        string $inv_nombre, 
        string $inv_descripcion, 
        int $inv_stock, 
        int $inv_precio, 
        string $tipo_unidad, 
        bool $inv_disponibilidad, 
        string $inv_img_url, 
        int $fk_id_categoria, 
        int $fk_id_bodega
    ) {
        try {
            $sql = "INSERT INTO inventario (inv_nombre, inv_descripcion, inv_stock, inv_precio, inv_tipo_unidad, inv_disponibilidad, inv_img_url, fk_id_categoria, fk_id_bodega)
                    VALUES (:inv_nombre, :inv_descripcion, :inv_stock, :inv_precio, :inv_tipo_unidad, :inv_disponibilidad, :inv_img_url, :fk_id_categoria, :fk_id_bodega)";
            $arrData = [
                "inv_nombre"         => $inv_nombre,
                "inv_descripcion"    => $inv_descripcion,
                "inv_stock"          => $inv_stock,
                "inv_precio"         => $inv_precio,
                "inv_tipo_unidad"        => $tipo_unidad,
                "inv_disponibilidad" => $inv_disponibilidad,
                "inv_img_url"        => $inv_img_url,
                "fk_id_categoria"    => $fk_id_categoria,
                "fk_id_bodega"       => $fk_id_bodega
            ];
            $result = $this->insert($sql, $arrData);

            print_r($result);
            return [
                "status" => true,
                "msg"    => "Inventario registrado correctamente",
                "id"     => $result["id"]
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al registrar el inventario: " . $e->getMessage()
            ];
        }
    }
    
    // Obtiene todos los inventarios
    public function obtenerTodosInventarios() {
        try {
            $sql = "SELECT * FROM inventario";
            return $this->select_all($sql);
        } catch(Exception $e) {
            throw new Exception("Error al obtener inventarios: " . $e->getMessage());
        }
    }
    
    // Obtiene un inventario por su ID
    public function obtenerPorIdInventario(int $id) {
        try {
            $sql = "SELECT * FROM inventario WHERE pk_id_inventario = :id";
            $arrData = [":id" => $id];
            return $this->select($sql, $arrData);
        } catch(Exception $e) {
            throw new Exception("Error al obtener el inventario: " . $e->getMessage());
        }
    }
    
    // Actualiza un inventario; si se envía nueva imagen se actualiza, de lo contrario se conserva la actual.
    public function actualizarInventario(
        int $id, 
        string $inv_nombre, 
        string $inv_descripcion, 
        int $inv_stock, 
        int $inv_precio, 
        string $tipo_unidad, 
        bool $inv_disponibilidad, 
        ?string $inv_img_url, 
        int $fk_id_categoria, 
        int $fk_id_bodega
    ) {
        try {
            if($inv_img_url !== null) {
                $sql = "UPDATE inventario 
                        SET inv_nombre = :inv_nombre, 
                            inv_descripcion = :inv_descripcion, 
                            inv_stock = :inv_stock, 
                            inv_precio = :inv_precio, 
                            inv_tipo_unidad = :inv_tipo_unidad, 
                            inv_disponibilidad = :inv_disponibilidad, 
                            inv_img_url = :inv_img_url, 
                            fk_id_categoria = :fk_id_categoria, 
                            fk_id_bodega = :fk_id_bodega 
                        WHERE pk_id_inventario = :id";
                $arrData = [
                    "inv_nombre"         => $inv_nombre,
                    "inv_descripcion"    => $inv_descripcion,
                    "inv_stock"          => $inv_stock,
                    "inv_precio"         => $inv_precio,
                    "inv_tipo_unidad"        => $tipo_unidad,
                    "inv_disponibilidad" => $inv_disponibilidad,
                    "inv_img_url"        => $inv_img_url,
                    "fk_id_categoria"    => $fk_id_categoria,
                    "fk_id_bodega"       => $fk_id_bodega,
                    "id"                 => $id
                ];
            } else {
                $sql = "UPDATE inventario 
                        SET inv_nombre = :inv_nombre, 
                            inv_descripcion = :inv_descripcion, 
                            inv_stock = :inv_stock, 
                            inv_precio = :inv_precio, 
                            tipo_unidad = :tipo_unidad, 
                            inv_disponibilidad = :inv_disponibilidad, 
                            fk_id_categoria = :fk_id_categoria, 
                            fk_id_bodega = :fk_id_bodega 
                        WHERE pk_id_inventario = :id";
                $arrData = [
                    "inv_nombre"         => $inv_nombre,
                    "inv_descripcion"    => $inv_descripcion,
                    "inv_stock"          => $inv_stock,
                    "inv_precio"         => $inv_precio,
                    "inv_tipo_unidad"        => $tipo_unidad,
                    "inv_disponibilidad" => $inv_disponibilidad,
                    "fk_id_categoria"    => $fk_id_categoria,
                    "fk_id_bodega"       => $fk_id_bodega,
                    "id"                 => $id
                ];
            }
            $this->update($sql, $arrData);
            return [
                "status" => true,
                "msg"    => "Inventario actualizado correctamente",
                "id"     => $id
            ];
        } catch(Exception $e) {
            return [
                "status" => false,
                "msg"    => "Error al actualizar el inventario: " . $e->getMessage()
            ];
        }
    }
    
    // Elimina un inventario
    public function eliminarInventario(int $id) {
        try {
            $sql = "DELETE FROM inventario WHERE pk_id_inventario = :id";
            $arrData = [":id" => $id];
            $result = $this->delete($sql, $arrData);
            return $result ? true : false;
        } catch(Exception $e) {
            throw new Exception("Error al eliminar el inventario: " . $e->getMessage());
        }
    }
}
?>
