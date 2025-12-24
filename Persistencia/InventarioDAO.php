<?php
require_once(__DIR__ . '/Conexion.php');

class InventarioDAO {

    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    // Obtener todos los productos
    public function obtenerInsumos() {
        $this->conexion->abrir();
        $this->conexion->ejecutar("SELECT * FROM producto ORDER BY idProducto ASC");
        $insumos = [];
        while($row = $this->conexion->registro()){
            $insumos[] = [
                'id' => $row[0],
                'producto' => $row[1],
                'precio' => $row[2],
                'cantidad' => $row[3]
            ];
        }
        $this->conexion->cerrar();
        return $insumos;
    }

    // Obtener producto por ID
    public function obtenerInsumoPorId($id) {
    $this->conexion->abrir();
    $this->conexion->ejecutar("SELECT * FROM producto WHERE idProducto = $id");
    $row = $this->conexion->registro();
    $this->conexion->cerrar();
    if($row){
        return [
            'idProducto' => $row[0],
            'nombre' => $row[1], // 'nombre' es la clave correcta
            'precio' => $row[2],
            'cantidad_stock' => $row[3] // Asegúrate de usar 'cantidad_stock' como clave
        ];
    }
    return null;
}

    // Insertar producto
    public function agregarInsumo($producto, $precio, $cantidad) {
        $this->conexion->abrir();
        $this->conexion->ejecutar("INSERT INTO producto (nombre, precio, cantidad_stock) VALUES ('$producto', $precio, $cantidad)");
        $this->conexion->cerrar();
    }

    // Editar producto
    public function editarInsumo($id, $producto, $precio, $cantidad) {
        $this->conexion->abrir();
        $this->conexion->ejecutar("UPDATE producto SET nombre='$producto', precio=$precio, cantidad_stock=$cantidad WHERE idProducto=$id");
        $this->conexion->cerrar();
    }

    // Eliminar producto
    public function eliminarInsumo($id) {
        $this->conexion->abrir();
        $this->conexion->ejecutar("DELETE FROM producto WHERE idProducto=$id");
        $this->conexion->cerrar();
    }
}
?>
