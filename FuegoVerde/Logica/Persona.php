<?php
abstract class Persona {
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $usuario;
    protected $clave;
    protected $rol;

    protected $estado;

    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
   
    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function Apellido()
    {
        return $this->apellido;
    }
   
    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }
     /**
     * @return mixed
     */
    public function getRol()
    {
        return $this->rol;
    }
        /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $nombre
     */
    public function setId($id)
    {
        $this->id= $id;
    }
    
    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }
    
    /**
     * @param mixed $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
       /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->rol = $estado;
    }

    public function __construct($id=0, $nombre="", $apellido ="", $usuario="", $clave="",$rol="",$estado=""){
        $this -> id = $id;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> usuario = $usuario;
        $this -> clave = $clave;
        $this -> rol = $rol;
        $this -> estado = $estado;
    }
}
?>
