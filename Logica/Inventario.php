<?php
require_once(__DIR__ . '/../Persistencia/InventarioDAO.php');

class Inventario {

    private $id;
    private $producto;
    private $precio;
    private $cantidad;

    private $dao;

    public function __construct($id=null){
        $this->id = $id;
        $this->dao = new InventarioDAO();
    }

    // Getters y setters
    public function getId(){ return $this->id; }
    public function getProducto(){ return $this->producto; }
    public function getPrecio(){ return $this->precio; }
    public function getCantidad(){ return $this->cantidad; }

    public function setId($id){$this->id = $id;}
    public function setProducto($p){ $this->producto = $p; }
    public function setPrecio($p){ $this->precio = $p; }
    public function setCantidad($c){ $this->cantidad = $c; }

    // Obtener todos los productos
    public function listarInsumos(){
        return $this->dao->obtenerInsumos();
    }

    // Obtener producto por ID
    public function consultarPorId(){
    if($this->id){
        $insumo = $this->dao->obtenerInsumoPorId($this->id);
        if($insumo){
            $this->producto = $insumo['nombre'];
            $this->precio = $insumo['precio'];
            $this->cantidad = $insumo['cantidad_stock'];
            return $insumo; // ✅ Retornar el array
        }
    }
    return null;
}

    // Agregar producto
    public function agregar(){
        $this->dao->agregarInsumo($this->producto, $this->precio, $this->cantidad);
    }

    // Editar producto
    public function editar(){
        $this->dao->editarInsumo($this->id, $this->producto, $this->precio, $this->cantidad);
    }

    // Eliminar producto
    public function eliminar(){
        $this->dao->eliminarInsumo($this->id);
    }
}
?>
