<?php
class EmpleadoInvDAO {
    private $id;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $rol;

    private $estado;


    public function __construct($id=0, $nombre="", $apellido="", $usuario="", $clave="",$rol="", $estado=""){
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> usuario = $usuario;
        $this -> clave = $clave;
        $this -> rol = $rol;
        $this -> estado = $estado;
    }
    
    public function autenticar(){
        return "select idUsuario,idRol, idEstado
                from usuario
                where correo = '" . $this -> correo . "' and clave = md5('" . $this -> clave . "')";
    }
      public function consultarPorID(){
        return "select nombre, apellido, correo, idRol, idEstado, clave
                from usuario
                where idUsuario = '" . $this -> id . "'";
    }
}