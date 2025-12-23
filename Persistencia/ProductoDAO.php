<?php

class ProductoDAO{
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
    public function crear(){
        return "insert into Producto(nombre, precio, cantidad_Stock)
                values ('" . $this -> nombre . "', " . $this -> precio . ", " . $this -> cantidad_Stock . ")";
    }
    public function consultar(){
        return "select idProducto, nombre, precio, cantidad_Stock
                from Producto";
    }

    
}
?>