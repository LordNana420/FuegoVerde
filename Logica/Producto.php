<?php
require_once __DIR__ . '/../Persistencia/Conexion.php';
require_once __DIR__ . '/../Persistencia/ProductoDAO.php';

class Producto{
    private $id;
    private $nombre;
    private $precio;
    private $cantidad_Stock;

    public function __construct($id=0, $nombre="", $precio=0, $cantidad_Stock=""){
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> precio = $precio;
        $this -> cantidad_Stock = $cantidad_Stock;
       
    }

    public function getId(){
        return $this -> id;
    }
    public function setId($id){
        $this -> id = $id;
    }
    public function getNombre(){
        return $this -> nombre;
    }
    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }
    
    public function getPrecio(){
        return $this -> precio;
    }
    public function setPrecio($precio){
        $this -> precio = $precio;
    }
    public function getCantidad_Stock(){
        return $this -> cantidad_Stock;
    }
    public function setCantidad_Stock($cantidad_Stock){
        $this -> cantidad_Stock = $cantidad_Stock;
    }
 

    public function crear(){
        $conexion = new Conexion();
        $conexion -> abrir();
        $productoDAO = new ProductoDAO("", $this -> nombre,  $this -> precio,$this->cantidad_Stock);        
        $conexion -> ejecutar($productoDAO -> crear());
        $conexion -> cerrar();
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrir();
        $productoDAO = new ProductoDAO();        
        $conexion -> ejecutar($productoDAO -> consultar());
        $productos = array();
        while (($tupla = $conexion -> registro()) != null){
            $producto = new Producto($tupla[0], $tupla[1], $tupla[2], $tupla[3]);
            array_push($productos, $producto);
        }
        $conexion -> cerrar();
        return $productos;
    }

    

}

?>