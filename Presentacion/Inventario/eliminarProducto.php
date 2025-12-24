<?php
if (session_status() == PHP_SESSION_NONE) session_start();

// Solo admins o empleados internos pueden eliminar
if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','empleadoInt'])){
    header('Location: ../../index.php');
    exit();
}

require_once(__DIR__ . '/../../Logica/Inventario.php');

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: index.php?pid=' . base64_encode('Presentacion/Inventario/inventario.php'));
    exit();
}

$idProducto = intval($_GET['id']);
$inventarioObj = new Inventario();
$inventarioObj->setId($idProducto);
$inventarioObj->eliminar();

// Redirigir de nuevo al inventario
header('Location: index.php?pid=' . base64_encode('Presentacion/Inventario/inventario.php'));
exit();
