<?php
require_once __DIR__ . '/../Persistencia/Conexion.php';
require_once __DIR__ . '/../Persistencia/VentaDAO.php';

class Venta {

    private $idUsuario;
    private $total;

    public function __construct($idUsuario = 0, $total = 0) {
        $this->idUsuario = $idUsuario;
        $this->total = $total;
    }

    public function registrarVentaMultiple($carrito) {

        $conexion = new Conexion();
        $conexion->abrir();

        // 1️⃣ Insertar encabezado de venta
        $ventaDAO = new VentaDAO();
        $conexion->ejecutar(
            $ventaDAO->crearVenta($this->idUsuario, $this->total)
        );

        $idVenta = $conexion->obtenerId();

        // 2️⃣ Insertar detalles y descontar stock
        foreach ($carrito as $item) {

            $conexion->ejecutar(
                $ventaDAO->crearDetalle(
                    $idVenta,
                    $item['id'],
                    $item['cantidad'],
                    $item['precio']
                )
            );

            $conexion->ejecutar(
                $ventaDAO->descontarStock(
                    $item['id'],
                    $item['cantidad']
                )
            );
        }

        $conexion->cerrar();
        return true;
    }
}
