<?php
if (session_status() == PHP_SESSION_NONE) session_start();

// Solo admins o empleados internos pueden acceder
if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','empleadoInt'])){
    header('Location: ../../index.php');
    exit();
}

require_once(__DIR__ . '/../../Logica/Inventario.php');

$inventarioObj = new Inventario();
$listaProductos = $inventarioObj->listarInsumos(); // método del objeto Inventario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Fuego Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2d9b9d9b9.js" crossorigin="anonymous"></script>
</head>
<body>

<?php include_once(__DIR__ . '/../menu.php'); ?>

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Gestionar Inventario</h2>

    <!-- Botón para agregar producto -->
    <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/agregarProducto.php'); ?>" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Agregar Producto
    </a>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="text-light" style="background-color: #1a6b4f;">
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaProductos as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['producto']); ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td>$<?php echo number_format($item['precio'],2,",","."); ?></td>
                        <td>
                            <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/editarProducto.php'); ?>&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning me-1">
                               <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/eliminarProducto.php'); ?>&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">
                               <i class="fas fa-trash-alt"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
