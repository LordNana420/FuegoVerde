<?php
class VentaDAO {

    public function crearVenta($idUsuario, $total) {
        return "INSERT INTO venta (idUsuario, fecha, total)
                VALUES ($idUsuario, NOW(), $total)";
    }

    public function crearDetalle($idVenta, $idProducto, $cantidad, $precioUnitario) {
        return "INSERT INTO detalle_venta (idVenta, idProducto, cantidad, precio_unitario)
                VALUES ($idVenta, $idProducto, $cantidad, $precioUnitario)";
    }

    public function descontarStock($idProducto, $cantidad) {
        return "UPDATE producto
                SET cantidad_stock = cantidad_stock - $cantidad
                WHERE idProducto = $idProducto";
    }
}
