<?php
require_once("persistencia/Conexion.php");
require_once("Persistencia/EmpleadoVendDAO.php");

class EmpleadoVend extends Persona {

    public function __construct($id=0, $nombre="", $apellido="", $usuario="", $clave="",$rol="",$estado=""){
        parent::__construct($id, $nombre, $apellido, $usuario, $clave, $rol,$estado);
    }
    
    public function autenticar(){
        $conexion = new Conexion();
        $conexion -> abrir();
        $adminDAO = new AdminDAO("", "", "", $this -> usuario, $this -> clave,"", $this ->rol);
        $conexion -> ejecutar($adminDAO -> autenticar());
        $tupla = $conexion -> registro();
        $conexion -> cerrar();
        if($tupla != null){
            $this -> id = $tupla[0];
            $this -> rol = $tupla[1];
            $this -> estado = $tupla[2];

            return true;
        }else{
            return false;
        }
    }

    public function consultarPorId(){
        $conexion = new Conexion();
        $conexion -> abrir();
        $adminDAO = new AdminDAO($this -> id);
        $conexion -> ejecutar($adminDAO -> consultarPorId());
        $tupla = $conexion -> registro();
        $conexion -> cerrar();
        $this -> nombre = $tupla[0];
        $this -> apellido = $tupla[1];
        $this -> correo = $tupla[2];
    }

    

    
}



?>